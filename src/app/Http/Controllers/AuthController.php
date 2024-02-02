<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function registerUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|',
            'phone_number' => 'required|numeric|digits:11'
        ]);

        try{
            
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }

        return response()->json([

        ]);

    }
}
