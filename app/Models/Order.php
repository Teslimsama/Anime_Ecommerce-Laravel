<?php

namespace App\Models;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon', 'coupon_id', 'influencer_id'];
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public static function calculateInfluencerCommission()
    {
        $influencerId = auth()->user()->id;
        // Retrieve orders associated with the influencer
        $orders = Order::where('influencer_id', $influencerId)->get();

        // Initialize variable to store total commission
        $totalCommission = 0;

        // Loop through each order to calculate commission
        foreach ($orders as $order) {
            // Assuming fixed commission per product
            $commissionPerProduct = 500; // Fixed commission amount per product

            // Count the number of products in the order
            $numberOfProducts = $order->cart_info->count();

            // Calculate total commission for this order
            $orderCommission = $commissionPerProduct * $numberOfProducts;

            // Add order commission to total
            $totalCommission += $orderCommission;
        }

        // Return the total commission
        return $totalCommission;
    }
    public static function calculateInfluencerCommissionForMonth()
    {
        $now = Carbon::now();

        // Get the influencer's ID
        $influencerId = auth()->user()->id;

        // Calculate the year, month, and day
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        // Retrieve orders associated with the influencer for the specified month
        $orders = Order::where('influencer_id', $influencerId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Initialize variable to store total commission
        $totalCommission = 0;

        // Assuming fixed commission per product
        $commissionPerProduct = 500; // Fixed commission amount per product

        // Loop through each order to calculate commission
        foreach ($orders as $order) {
            // Count the number of products in the order
            $numberOfProducts = $order->cart_info->count();

            // Calculate total commission for this order
            $orderCommission = $commissionPerProduct * $numberOfProducts;

            // Add order commission to total
            $totalCommission += $orderCommission;
        }

        // Return the total commission for the month
        return $totalCommission;
    }

    public static function calculateInfluencerCommissionForDay()
    {
        $now = Carbon::now();

        // Get the influencer's ID
        $influencerId = auth()->user()->id;

        // Calculate the year, month, and day
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        // Retrieve orders associated with the influencer for the specified day
        $orders = Order::where('influencer_id', $influencerId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->get();

        // Initialize variable to store total commission
        $totalCommission = 0;

        // Assuming fixed commission per product
        $commissionPerProduct = 500; // Fixed commission amount per product

        // Loop through each order to calculate commission
        foreach ($orders as $order) {
            // Count the number of products in the order
            $numberOfProducts = $order->cart_info->count();

            // Calculate total commission for this order
            $orderCommission = $commissionPerProduct * $numberOfProducts;

            // Add order commission to total
            $totalCommission += $orderCommission;
        }

        // Return the total commission for the day
        return $totalCommission;
    }

    public static function countActiveOrdersByInfluencer()
    {
        $influencerId = auth()->user()->id;
        $data = Order::where('status', 'active')
        ->where('influencer_id', $influencerId)
            ->count();
        return $data;
    }

    public static function countNewReceivedOrderByInfluencer()
    {
        $influencerId = auth()->user()->id;
        $data = Order::where('status', 'new')
        ->where('influencer_id', $influencerId)
            ->count();
        return $data;
    }

    public static function countProcessingOrderByInfluencer()
    {
        $influencerId = auth()->user()->id;
        $data = Order::where('status', 'process')
        ->where('influencer_id', $influencerId)
            ->count();
        return $data;
    }

    public static function countDeliveredOrderByInfluencer()
    {
        $influencerId = auth()->user()->id;
        $data = Order::where('status', 'delivered')
        ->where('influencer_id', $influencerId)
            ->count();
        return $data;
    }

    public static function countCancelledOrderByInfluencer()
    {
        $influencerId = auth()->user()->id;
        $data = Order::where('status', 'cancel')
        ->where('influencer_id', $influencerId)
            ->count();
        return $data;
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public static function countNewReceivedOrder(){
        $data = Order::where('status', 'new')->count();
        return $data;
    }
    public static function countProcessingOrder(){
        $data = Order::where('status', 'process')->count();
        return $data;
    }
    public static function countDeliveredOrder(){
        $data = Order::where('status', 'delivered')->count();
        return $data;
    }
    public static function countCancelledOrder(){
        $data = Order::where('status', 'cancel')->count();
        return $data;
    }
    

}
