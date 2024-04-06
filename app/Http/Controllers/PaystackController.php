<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paystack;
use App\Models\Cart;
use App\Models\Order;
use Helper;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Shipping;

class PaystackController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGateway(Request $request)
    {
        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['product_id'] = $request->product_id;
        $order_data['shipping_id'] = $request->shipping;
        $shipping = Shipping::where('id', $order_data['shipping_id'])->pluck('price');
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        $order_data['payment_method'] = $request->payment_method;
        $order_data['payment_status'] = 'paid';
        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
            $order_data['coupon_id'] = session('coupon')['id'];
            $order_data['influencer_id'] = session('coupon')['influencer_id'];
        }
        if ($request->shipping) {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0];
            }
        } else {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice();
            }
        }
        $order->fill($order_data);
        $order->save();
        // Update the 'order_id' in the cart
        Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->update(['order_id' => $order->id]);

        // Continue with Paystack integration
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
        $data['amount'] = $this->formatPrice($order_data['total_amount']);
        $data['email'] = auth()->user()->email;
        $data['callback_url'] = route('payment');
        // dd($data);

        // Redirect to Paystack for payment
        return Paystack::getAuthorizationUrl($data)->redirectNow();
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
            request()->session()->flash('success', 'You have successfully paid through Paystack! Thank You');
            session()->forget('cart');
            session()->forget('coupon');
            return redirect()->route('home');
        } else {
            // Payment failed, handle accordingly

            request()->session()->flash('error', 'Something went wrong please try again!!!');
            return redirect()->route('home');
        }
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
