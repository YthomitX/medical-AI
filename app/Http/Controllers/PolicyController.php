<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Exports\PoliciesExport;
use Maatwebsite\Excel\Facades\Excel;

class PolicyController extends Controller
{
    // Show all policies with search, sort, and pagination
    public function index(Request $request)
    {
        $query = Policy::query();

        // Search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->get('sort', 'created_at'); // default sort by date
        $direction = $request->get('direction', 'desc'); // default newest first
        $perPage = $request->get('perPage', 10); // default 10 per page

        if (in_array($sort, ['title', 'created_at', 'uploaded_by'])) {
            $query->orderBy($sort, $direction);
        }

        // Paginate results
        $policies = $query->paginate($perPage)->withQueryString();

        return view('policies.index', compact('policies', 'sort', 'direction'));
    }

    // Export filtered policies to CSV or Excel
    public function export(Request $request)
    {
        $query = Policy::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (in_array($sort, ['title', 'created_at', 'uploaded_by'])) {
            $query->orderBy($sort, $direction);
        }

        $format = $request->get('format', 'csv'); // default CSV

        if ($format === 'excel') {
            $filename = 'policies_export_' . now()->format('Ymd_His') . '.xlsx';
            return Excel::download(new PoliciesExport($query->get()), $filename);
        }

        // Fallback: CSV
        $policies = $query->get(['title', 'filename', 'uploaded_by', 'created_at']);
        $filename = 'policies_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($policies) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Title', 'Filename', 'Uploaded By', 'Created At']);
            foreach ($policies as $policy) {
                fputcsv($handle, [
                    $policy->title,
                    $policy->filename,
                    $policy->uploaded_by,
                    $policy->created_at ? $policy->created_at->format('Y-m-d H:i:s') : null,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Show the upload form
    public function create()
    {
        return view('policies.create');
    }

    // Edit function
    public function edit(Policy $policy)
    {
        return view('policies.edit', compact('policy'));
    }

    // Update function
    public function update(Request $request, Policy $policy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx|max:10240'
        ]);

        $policy->title = $request->title;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $hash = hash_file('sha256', $file->getRealPath());

            // Prevent duplicate uploads
            if (Policy::where('file_hash', $hash)
                ->where('id', '!=', $policy->id)
                ->exists()) {
                return redirect()->back()
                    ->withErrors(['file' => 'This file has already been uploaded in another policy.']);
            }

            // Delete old file
            if ($policy->path && Storage::disk('public')->exists($policy->path)) {
                Storage::disk('public')->delete($policy->path);
            }

            // Store new file
            $path = $file->store('policies', 'public');
            $policy->filename = $file->getClientOriginalName();
            $policy->path = $path;
            $policy->file_hash = $hash;
        }

        $policy->save();

        // Notify Flask to reindex updated file
        $this->notifyFlask($policy);

        return redirect()->route('policies.index')->with('success', 'Policy updated and indexed successfully!');
    }

    // Delete function
    public function destroy(Policy $policy)
    {
        // Delete file from storage
        if ($policy->path) {
            Storage::disk('public')->delete($policy->path);
        }

        // Notify Flask to drop chunks
        Http::post('http://127.0.0.1:5000/delete_policy', [
            'filename' => $policy->filename
        ]);

        // Delete policy record from DB
        $policy->delete();

        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully!');
    }

    // Handle file upload
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10240'
        ]);

        $file = $request->file('file');
        $title = $request->title;

        // Force filename to match given title
        $safeTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $title); // sanitize
        $filename = $safeTitle . '.pdf';

        // Store file with controlled name
        $path = $file->storeAs('policies', $filename, 'public');

        Policy::create([
            'title' => $title,
            'filename' => $filename,
            'path' => $path,
            'uploaded_by' => auth()->id() ?? 0,
            'file_hash'   => hash_file('sha256', $file->getRealPath()),
        ]);

        return redirect()->route('policies.index')->with('success', 'Policy uploaded successfully!');
    }

    // Helper to notify Flask backend
    private function notifyFlask(Policy $policy)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $flaskResponse = $client->post('http://127.0.0.1:5000/reindex', [
                'json' => [
                    'title' => $policy->title,
                    'path' => storage_path('app/public/' . $policy->path)
                ],
                'timeout' => 30,
                'connect_timeout' => 5
            ]);

            \Log::info('Flask reindex response: ' . $flaskResponse->getBody());
        } catch (\Exception $e) {
            \Log::error('Failed to notify Flask: ' . $e->getMessage());
        }
    }
}



