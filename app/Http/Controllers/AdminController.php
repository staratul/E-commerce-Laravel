<?php

namespace App\Http\Controllers;

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
        return view('admin.pages.dashboard');
    }

}
