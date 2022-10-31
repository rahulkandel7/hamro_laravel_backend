<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class OtherController extends Controller
{
    public function getUser()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }

    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'address' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg',
            'phone_number' => 'required',
            'gender' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

        if ($request->has('profile_photo')) {
            $fname = Str::random(20);
            $fexe = $request->file('profile_photo')->extension();
            $fpath = "$fname.$fexe";

            $request->file('profile_photo')->storeAs('public/profiles', $fpath);
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            $data['profile_photo'] = 'profiles/' . $fpath;
        }

        $user->update($data);
        return response()->json([
            'message' => 'User Updated Successfully',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            're_password' => 'required|same:new_password',
        ]);

        if(Hash::check($request->input('current_password'),Auth::user()->password)){
            $password = Hash::make($request->input('new_password'));
            $user = User::find(Auth::id());
            $user->password = $password;
            $user->update();
            return response()->json([
                'message' => 'Password Changed Successfully',
                'status' => true,
                'data' => $data,
            ], 200);
        }

        else
        {
            return response()->json([
                'message' => 'Incorrect Current Password',
                'status' => false,
                'data' => $data,
            ], 200);
        }

    }
}
