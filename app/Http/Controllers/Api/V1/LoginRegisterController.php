<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LoginRegisterController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $id = Auth::user()->id;
            $user = User::findOrFail($id);

            $token =  $user->createToken('hamro-electronics')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Login Success'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ], 422);
        }
    }

    public function register(RegisterRequest $request)
    {

        $data = $request->all();

        $data['password'] = bcrypt($data['password']);
        if ($request->profile_photo) {
            if ($request->has('profile_photo')) {
                $fname = Str::random(20);
                $fexe = $request->file('profile_photo')->extension();
                $fpath = "$fname.$fexe";

                $request->file('profile_photo')->storeAs('public/profiles', $fpath);

                $data['profile_photo'] = 'profiles/' . $fpath;
            }
        }


        $user = User::create($data);
        $token =  $user->createToken('hamro-electronics')->plainTextToken;


        return
            response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Register Success'
            ], 200);
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Success'
        ], 200);
    }
}
