<?php

namespace App\Http\Controllers\Users;

use App\User;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userProfile()
    {
        $user = auth()->user();
        $user->user_detail = $user->user_detail;
        return view('frontend.users.usersprofile', compact('user'));
    }

    public function userProfileUpdate(Request $request, User $user)
    {
        $isUser = UserDetail::where('email', $request->email)->first();

        $id = User::where('id', $user->id)->update([
            'name' => $request->fullName,
            'email' => $request->email,
            'phone' => $request->mobile
        ]);

        if($isUser) {
            $userDetail = UserDetail::where('id', $isUser->id)->update([
                'user_id' => $user->id
            ]);
        } else {
            $userDetail = UserDetail::create([
                'email' => $request->email,
                'user_id' => $user->id,
                'first_name' => $request->fullName,
                'address1' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'phone' => $request->mobile,
                'is_register' => '1'
            ]);
        }

        Session::flash('success', 'Your Profile Updated Successfully.');
        return back();
    }
}
