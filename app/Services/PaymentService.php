<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaymentService
{
    protected PayPalHttpClient $paypal;

    public function __construct()
    {
        $clientId     = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        $mode         = config('services.paypal.mode', 'sandbox'); // sandbox or live

        $environment = $mode === 'live'
            ? new ProductionEnvironment($clientId, $clientSecret)
            : new SandboxEnvironment($clientId, $clientSecret);

        $this->paypal = new PayPalHttpClient($environment);
    }

    /**
     * Create a PayPal order and return the approval URL.
     *
     * @param  array  $items Each item: ['name' => string, 'price' => float, 'quantity' => int]
     * @param  string $successUrl
     * @param  string $cancelUrl
     * @return string
     * @throws \Exception
     */
    public function createCheckoutSession(array $items, string $successUrl, string $cancelUrl): string
    {
        $paypalItems = [];
        $total       = 0;

        foreach ($items as $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $total    += $lineTotal;

            $paypalItems[] = [
                'name'        => $item['name'],
                'unit_amount' => [
                    'currency_code' => 'PHP',
                    'value'         => number_format($item['price'], 2, '.', ''),
                ],
                'quantity'    => (string) $item['quantity'],
            ];
        }

        $totalFormatted = number_format($total, 2, '.', '');

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            // 🔹 auto-capture payment
            'intent'         => 'CAPTURE',

            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'PHP',
                    'value'         => $totalFormatted,
                    'breakdown'     => [
                        'item_total' => [
                            'currency_code' => 'PHP',
                            'value'         => $totalFormatted,
                        ],
                    ],
                ],
                'items' => $paypalItems,
            ]],

            'application_context' => [
                // 🔹 use the correct variable name
                'return_url' => $successUrl,
                'cancel_url' => $cancelUrl,

                // 🔹 this changes button text to “Pay Now” on the approval page
                'user_action' => 'PAY_NOW',

                // Optional: if you don’t need a shipping address from PayPal
                // 'shipping_preference' => 'NO_SHIPPING',
            ],
        ];

        $response = $this->paypal->execute($request);

        if ($response->statusCode !== 201) {
            throw new \Exception('Failed to create PayPal order.');
        }

        $approvalLink = collect($response->result->links ?? [])
            ->firstWhere('rel', 'approve');

        if (!$approvalLink) {
            throw new \Exception('No approval link returned from PayPal.');
        }

        return $approvalLink->href;
    }
}
