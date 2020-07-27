<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManageController extends Controller
{
    public function uniqueVisitors()
    {
        return view('admin.pages.users.uniquevisitors');
    }

    public function userList(Request $request)
    {
        $users = User::latest()->get();
        if($request->ajax()) {
            return response()->json($users);
        }
        return view('admin.pages.users.userslist', compact('users'));
    }

    public function userStore(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        if(isset($request->user_id)) {
            $rules['email'] = ['required','string','email','max:255',
                                    Rule::unique('users')->ignore($request->user_id)];
            if(isset($request->password)) {
                $rules['password'] = 'required|string|min:8';
            }
        } else {
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8';
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 400);
        }

        if(isset($request->user_id)) {
            if(isset($request->password))  {
                User::where('id', $request->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                User::where('id', $request->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            }
            return response()->json(['msg' => 'User Updated Successfully!']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['msg' => 'User Created Successfully!']);
    }

    public function userEdit(User $user)
    {
        return response()->json($user);
    }

}
