<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomAudienceRequest;

class AudienceLoginController extends Controller
{
    
    public function audienceLogin(Request $request)
    {
        $this->validate($request, [
            'credential' => 'required',
            'password_or_pin' => 'required',
        ]);

        try{
            $audience = Audience::where(function ($query) use ($request) {
                $query->where('email', $request->credential)
                    ->orWhere('phone_number', $request->credential);
            })->first();

            if (is_null($audience)) {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
    
            if (Hash::check($request->password_or_pin, $audience->password) || $request->password_or_pin === $audience->pin) {
                $data['au$audience'] = $audience;
                $data['token'] = $audience->createToken('Nova')->accessToken;

                return response()->json(['is_correct' => true, 'message' => 'Login Successful', 'data' => $data], 200);

            } else {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
        }catch(\Exception $exception){
            
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function audienceLogout(CustomAudienceRequest $request)
    {
        

        //  $user = Auth::guard('audience');
        // if (!$user) {
        //     $user->token()->revoke();
            
        //     return response()->json([
        //         'message' => 'Successfully logged out'
        //     ], 204);
        // }

        $audience = $request->audience();
        if ($audience) {
            $token = $request->user('audience')->token();
            if ($token) {
                $token->revoke();
                return response()->json([
                    'message' => 'Successfully logged out'
                ], 204);
            }
        }

        return response()->json([
            'message' => 'No authenticated audience found'
        ], 401);


        // $user = Auth::guard('audience')->logout();

        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ], 204);
        /*
        $audience = $request->audience();
        if ($audience) {
            if (Gate::allows('perform-logout', $audience)) {
                $token = $audience->token();
                if ($token) {
                    $token->revoke();
                    return response()->json([
                        'message' => 'Successfully logged out'
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'No token found for the authenticated audience'
                    ], 401);
                }
            } else {
                return response()->json([
                    'message' => 'This action is unauthorized.'
                ], 403);
            }
        }

        return response()->json([
            'message' => 'No authenticated audience found'
        ], 401);

        */

       
        
        

        // $request->audience()->token()->revoke();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ], 204);

        // $audience = $request->audience();
        // if ($audience) {
        //     $audience->token()->revoke();
        //     return response()->json([
        //         'message' => 'Successfully logged out'
        //     ], 204);
        // }

        // return response()->json([
        //     'message' => 'No authenticated audience found'
        // ], 401);

    }
}

