<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;

class MidCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $influencerId = auth()->user()->id;

        $coupons = Coupon::orderBy('id', 'DESC')
            ->where('influencer_id', $influencerId)
            ->paginate(10);

        return view('influencer.coupon.index')->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('influencer.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);

        // Get the influencer's ID
        $influencerId = auth()->user()->id;

        // Add influencer ID to the request data
        $data = $request->all();
        $data['influencer_id'] = $influencerId;

        // Create the coupon
        $status = Coupon::create($data);

        // Check if the coupon was created successfully
        if ($status) {
            request()->session()->flash('success', 'Coupon added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('influencer.coupon.edit')->with('coupon', $coupon);
        } else {
            return view('influencer.coupon.index')->with('error', 'Coupon not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();

        $status = $coupon->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Coupon updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                request()->session()->flash('success', 'Coupon deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('coupon.index');
        } else {
            request()->session()->flash('error', 'Coupon not found');
            return redirect()->back();
        }
    }

    public function couponStore(Request $request)
    {
        // return $request->all();
        $coupon = Coupon::where('code', $request->code)->first();
        // dd($coupon);
        if (!$coupon) {
            request()->session()->flash('error', 'Invalid coupon code, Please try again');
            return back();
        }
        if ($coupon) {
            $total_price = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->sum('price');
            // dd($total_price);
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);
            request()->session()->flash('success', 'Coupon successfully applied');
            return redirect()->back();
        }
    }
}
