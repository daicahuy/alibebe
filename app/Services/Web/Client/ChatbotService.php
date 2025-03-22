<?php

namespace App\Services\Web\Client;

use GuzzleHttp\Client;

class ChatbotService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function generateText($prompt)
{
    // $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent"; // bản v1beta thử nghiệm chạy các con thinking
    $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent"; // bản chuẩn chạy flash
    
    \Log::info('Gemini API Request URL: ' . $url); // Log URL
    \Log::info('Gemini API Request Headers:', [ // Log headers
        'Content-Type' => 'application/json',
        'x-goog-api-key' => $this->apiKey,
    ]);

    try {
        $response = $this->client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->apiKey,
            ],
            'json' => [
                'contents' => [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody(), true);

    } catch (\Exception $e) {
        \Log::error('Gemini API Error: '.$e->getMessage());
        return ['error' => $e->getMessage()];
    }
}
}