<?php

namespace App\Exports;

use App\Models\Policy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PoliciesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $policies;

    // Accept filtered collection from controller
    public function __construct($policies)
    {
        $this->policies = $policies;
    }

    // Provide the data rows
    public function collection()
    {
        return $this->policies;
    }

    // Map each row for formatting
    public function map($policy): array
    {
        return [
            $policy->title,
            $policy->filename,
            $policy->uploaded_by,
            $policy->created_at ? $policy->created_at->format('Y-m-d H:i:s') : null,
        ];
    }

    // Provide column headings
    public function headings(): array
    {
        return ['Title', 'Filename', 'Uploaded By', 'Created At'];
    }

    // Optional: style headings row
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}


