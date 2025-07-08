<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardSearatesAPI extends Controller
{
    public function index()
    {
        return view('dashboard', ['trackingData' => null]);
    }

    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'bl_number' => 'required|string|max:50'
        ]);

        $apiKey = env("API_KEYY");
        $blNumber = strtoupper(trim($request->input('bl_number')));

        // Cek apakah API key tersedia
        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'error' => 'API key not configured. Please check your .env file.'
            ], 500);
        }

        try {
            // Call Searates API
            $response = Http::timeout(30)->get("https://tracking.searates.com/tracking", [
                'api_key' => $apiKey,
                'number' => $blNumber
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Cek apakah response berhasil
                if (isset($data['status']) && $data['status'] === 'success') {
                    Log::info("Tracking search successful for BL: {$blNumber}");
                    return response()->json($data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'error' => $data['message'] ?? 'Invalid response from tracking API'
                    ], 404);
                }
            } else {
                // HTTP error
                $statusCode = $response->status();
                $errorMessage = "API request failed";

                if ($statusCode === 401) {
                    $errorMessage = "Invalid API key. Please check your API credentials.";
                } elseif ($statusCode === 404) {
                    $errorMessage = "BL Number '{$blNumber}' not found in the system.";
                } elseif ($statusCode === 429) {
                    $errorMessage = "API rate limit exceeded. Please try again later.";
                }

                Log::warning("Tracking API error for BL {$blNumber}: {$errorMessage}");

                return response()->json([
                    'status' => 'error',
                    'error' => $errorMessage
                ], $statusCode);
            }
        } catch (\Exception $e) {
            Log::error("Error for BL {$blNumber}: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'error' => 'An error occurred while fetching tracking data. Please try again.'
            ], 500);
        }
    }
}
