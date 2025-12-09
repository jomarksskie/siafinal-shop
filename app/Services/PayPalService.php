<?php

namespace App\Services;

use App\Models\Order;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalService
{
    protected PayPalHttpClient $client;

    public function __construct()
    {
        $clientId = config('services.paypal.client_id');
        $secret   = config('services.paypal.secret');
        $mode     = config('services.paypal.mode', 'sandbox');

        $env = $mode === 'live'
            ? new ProductionEnvironment($clientId, $secret)
            : new SandboxEnvironment($clientId, $secret);

        $this->client = new PayPalHttpClient($env);
    }

    public function createOrder(Order $order): array
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => (string) $order->id,
                "amount" => [
                    "currency_code" => "PHP",
                    "value" => number_format($order->total, 2, '.', '')
                ]
            ]],
            "application_context" => [
                "return_url" => route('checkout.success', $order),
                "cancel_url" => route('checkout.cancel', $order),
            ]
        ];

        $response = $this->client->execute($request);
        $approve = collect($response->result->links)
            ->firstWhere('rel', 'approve');

        return [
            'id' => $response->result->id,
            'approve_url' => $approve->href,
        ];
    }

    public function captureOrder(string $paypalOrderId): void
    {
        $request = new OrdersCaptureRequest($paypalOrderId);
        $this->client->execute($request);
    }
}
