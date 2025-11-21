<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY');
    }

    public function sendMessage($target, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message
        ]);

        return $response->json();
    }
}
//