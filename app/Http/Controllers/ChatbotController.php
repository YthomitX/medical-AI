<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function query(Request $request)
    {
        $userInput = strtolower(trim($request->input('question')));

        // ✅ Local keyword handling (only if the query is *just* a greeting)
        if (in_array($userInput, ['hello', 'hi'])) {
            return response()->json(['answer' => 'Hello! How can I help you today?']);
        }

        if ($userInput === 'date') {
            return response()->json(['answer' => 'Today is ' . now()->format('F d, Y')]);
        }

        if ($userInput === 'time') {
            return response()->json(['answer' => 'The current time is ' . now()->format('h:i A')]);
        }

        if (str_contains($userInput, 'weather')) {
            try {
                $client = new Client();
                $apiKey = config('services.openweather.key');

                if (!$apiKey) {
                    return response()->json(['answer' => '⚠️ Weather API key missing.']);
                }

                $response = $client->get("https://api.openweathermap.org/data/2.5/weather?q=Manila,PH&appid={$apiKey}&units=metric");
                $data = json_decode($response->getBody(), true);

                if (!isset($data['main'])) {
                    return response()->json(['answer' => '⚠️ Weather service unavailable.']);
                }

                $temp = $data['main']['temp'];
                $desc = ucfirst($data['weather'][0]['description']);
                $humidity = $data['main']['humidity'];

                return response()->json([
                    'answer' => "Current weather in Manila: $desc, $temp °C, humidity $humidity%."
                ]);
            } catch (\Exception $e) {
                return response()->json(['answer' => '⚠️ Weather API error: ' . $e->getMessage()]);
            }
        }

        // ✅ Fallback to Flask backend
        try {
            $client = new Client();
            $response = $client->post('http://127.0.0.1:5000/query', [
                'json' => ['question' => $userInput],
                'timeout' => 60,
                'connect_timeout' => 5
            ]);

            $decoded = json_decode($response->getBody(), true);

            Log::channel('chatbot')->info('Chatbot answer', [
                'question' => $userInput,
                'answer'   => $decoded['answer'] ?? '',
                'sources'  => $decoded['sources'] ?? [],
                'excerpts' => $decoded['excerpts'] ?? []
            ]);

            if (json_last_error() === JSON_ERROR_NONE && !empty($decoded['answer'])) {
                return response()->json([
                    'answer'  => $decoded['answer'],
                    'sources' => $decoded['sources'] ?? [],
                ]);
            } else {
                Log::channel('chatbot')->warning("No relevant answer for: {$userInput}");
                return response()->json([
                    'answer' => "I couldn’t find relevant information in the uploaded documents. Please check the official PCG guidelines.",
                    'sources' => []
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('chatbot')->error("Flask error: " . $e->getMessage());
            return response()->json(['answer' => 'Information unavailable']);
        }
    }
}
