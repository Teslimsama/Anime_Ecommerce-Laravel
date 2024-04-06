<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paystack;
use App\Models\Cart;
use App\Models\Product;

class PaystackController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGateway(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->get()
            ->toArray();

        $data = [];

        $data['items'] = array_map(function ($item) {
            $product = Product::where('id', $item['product_id'])->first();
            return [
                'name' => $product->title,
                'price' => $item['price'],
                'desc' => 'Thank you for using Paystack',
                'qty' => $item['quantity']
            ];
        }, $cart);

        $data['invoice_id'] = 'ORD-' . strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['metadata'] = [
            'invoiceId' => $data['invoice_id']
        ];
        $data['amount'] = $this->formatPrice($this->getTotalPrice($data['items']));
        $data['email'] = auth()->user()->email;
        $data['callback_url'] = route('payment.callback');

        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Handle Paystack Payment Callback
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();
        $status = $paymentDetails['data']['status'];

        if ($status == "success") {
            // Payment successful, handle accordingly
            // For example, update database, send email, etc.
            return redirect()->route('payment.success');
        } else {
            // Payment failed, handle accordingly
            return redirect()->route('payment.failure');
        }
    }

    /**
     * Get total price of items in cart
     *
     * @param array $items
     * @return float
     */
    private function getTotalPrice(array $items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    /**
     * Format price to kobo (integer)
     *
     * @param float $price
     * @return int
     */
    private function formatPrice($price)
    {
        return (int) ($price * 100); // Convert to kobo
    }
}
