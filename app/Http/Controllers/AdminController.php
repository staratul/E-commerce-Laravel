<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Frontend\Order;
use App\Models\Admin\Products\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function admin()
    {
        return redirect()->route('admin.dashboard');
    }

    public function index()
    {
        $users = User::select('id', 'created_at')
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->created_at)->format('m');
                            });

        $user = new User();
        $userCount = $user->userCountByMonths($users);
        $orders = Order::all();
        $totalOrder = Order::count();
        $totalUser = User::count();
        $totalProduct = Product::count();
        return view('admin.pages.dashboard', compact('totalOrder','totalUser','totalProduct','orders', 'userCount'));
    }

}
