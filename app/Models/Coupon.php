<?php

namespace App\Models;

use App\Models\Order;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'status', 'influencer_id','coupon_id'];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }
    public function discount($total)
    {
        if ($this->type == "fixed") {
            return $this->value;
        } elseif ($this->type == "percent") {
            return ($this->value / 100) * $total;
        } else {
            return 0;
        }
    }
    public function influencer()
    {
        return $this->belongsTo(User::class, 'influencer_id');
    }
}
