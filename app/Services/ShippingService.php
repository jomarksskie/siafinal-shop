<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShippingService
{
    public function getRate(string $city): int
    {
        // Mock API example using a free dummy endpoint
        // If offline, fallback to flat rate.
        try {
            $resp = Http::get('https://mocki.io/v1/0a4b9c4b-6b75-4f2f-a1c4-0b5b6c2f0c5a', [
                'city' => $city
            ]);

            if ($resp->ok() && isset($resp['rate'])) {
                return (int) $resp['rate'];
            }
        } catch (\Exception $e) {
            // ignore fail
        }

        return 80; // fallback flat shipping
    }
}
