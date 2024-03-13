<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon','influencer'];

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
