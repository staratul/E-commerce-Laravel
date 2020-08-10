<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Frontend\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Products\Product;
use App\Models\Frontend\Contact;

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
        $notifications = DB::table('notifications')
                            ->where('type', 'App\Notifications\NewContactMessage')
                            ->whereNull('read_at')
                            ->count();

        $totalMessages = Contact::count();
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
        return view('admin.pages.dashboard', compact('totalOrder','totalUser','totalProduct','orders', 'userCount','notifications', 'totalMessages'));
    }

}
