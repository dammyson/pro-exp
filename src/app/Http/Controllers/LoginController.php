<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'credential' => 'required',
            'password_or_pin' => 'required',
        ]);

        try{
            $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->credential)
                      ->orWhere('username', $request->credential)
                      ->orWhere('phone_number', $request->credential);
            })->first();

            if (is_null($user)) {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 400);
            }
    
            if (Hash::check($request->password_or_pin, $user->password) || $request->password_or_pin === $user->pin) {
                $data['user'] = $user;
                $data['token'] = $user->createToken('Nova')->accessToken;

                return response()->json(['is_correct' => true, 'message' => 'Login Successful', 'data' => $data], 200);
            } else {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 400);
            }
        }catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 201);
    }
}
