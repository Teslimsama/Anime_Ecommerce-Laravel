<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;

class MidAdminController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('influencer.index')->with('users', json_encode($array));
    }
    public function orderIndex()
    {
        $influencerId = auth()->user()->id;
        $orders = Order::orderBy('id', 'DESC')
            ->where('influencer_id', $influencerId)
            ->paginate(10);
        return view('influencer.order.index')->with('orders', $orders);
    }


    public function orderShow($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('influencer.order.show')->with('order', $order);
    }
    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('influencer.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated your profile');
        } else {
            request()->session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }
    public function changePassword()
    {
        return view('influencer.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('midadmin')->with('success', 'Password changed successfully');
    }
    public function incomeChart()
    {
        // Initialize an array to store monthly commission data
        $monthlyCommission = [];

        // Get the current year
        $year = \Carbon\Carbon::now()->year;

        // Loop through each month of the year
        for ($month = 1; $month <= 12; $month++) {
            // Retrieve orders associated with the influencer for the current month
            $influencerId = auth()->user()->id;
            $orders = Order::where('influencer_id', $influencerId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();

            // Initialize variable to store total commission for the month
            $totalCommission = 0;

            // Loop through each order to calculate commission
            foreach ($orders as $order) {
                // Calculate commission for each product based on fixed commission per product
                $totalCommission += 500;
            }

            // Store the total commission for the month
            $monthlyCommission[date('F', mktime(0, 0, 0, $month, 1))] = $totalCommission;
        }

        $data = $monthlyCommission;
        // Return the monthly commission data to the view
        return $data;
    }
}
