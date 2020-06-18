<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:admin');
	}


    public function showLoginForm()
    {
    	return view('auth.admin_login');
    }


    public function login(Request $request)
    {
    	// Validate the Form Data
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	]);

    	// Attempt to log the use in
    	if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
    	{
    		// if successfull, then redirect to their intended location
    		return redirect()->intended(route('admin.dashboard'));
    	}

    	// if unsuccessfull, then redirect to the back on login form
    		return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
