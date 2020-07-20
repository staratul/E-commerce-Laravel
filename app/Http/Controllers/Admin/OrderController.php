<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Frontend\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereNotNull('payment_type_id')
                            ->where('is_confirm', '1')
                            ->with('userDetails')
                            ->with('product')
                            ->with('payment_type')
                            ->latest()
                            ->get();
        // dd($orders);
        return view('admin.pages.orders', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderDetails(Order $order)
    {
        $order = Order::where('id', $order->id)
                            ->where('is_confirm', '1')
                            ->with('userDetails')
                            ->with('product')
                            ->with('payment_type')
                            ->latest()
                            ->first();
// dd($order);
        return view('admin.pages.order_details', compact('order'));
    }
}
