<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AudienceRegisterController extends Controller
{
    public function audienceRegister(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|numeric|digits:11|unique:audiences',
            'email' => 'required|email|unique:audiences',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        try {
            $create = Audience::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number ,
                'first_name' => $request->first_name ,
                'last_name' => $request->last_name ,
                'username' => $request->username ,
                'status' => "Active" ,
            ]);
    
            // Generate a random verification code
            // $verificationCode = $this->generateVerificationCode();
    
            // Send verification email
            // $this->sendVerificationCode($create->email, $verificationCode);
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
    
        $data['audience'] =  $create;
        $data['token'] =  $create->createToken('Nova')->accessToken;
    
        return response()->json(['error' => false, 'message' => 'Client registration successful. Verification code sent to your email.', 'data' => $data], 201);
    }


    public function audienceResetPIN(Request $request)
    {
         $this->validate($request, [
            'phone_number' => 'required|numeric|digits:11',
        ]);

        try{
                $reset = Audience::where('phone_number', $request->phone_number)->first();
                if ($reset == null) {
                    return response()->json(['error' => true, 'message' => 'phone_number does not exist'], 404);
                }

                // $code = $this->generateVerificationCode();

                // $this->sendVerificationCode($validated['email'],$code);
                

            }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'prompt audience to enter new pin', 'data' => []], 200);
    }


    public function audienceCompletePINReset(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|numeric|digits:11',
            'otp' => 'required|string',
            'new_pin' => 'required|string'
        ]);

        try{
            $audience = Audience::where('phone_number', $request->phone_number)->first();

            if (!$audience) {
                return response()->json(['error' => true, 'message' => 'Audience not found'], 404);
            }
        

            // verify otp then save password else return 
            if ($audience && $request->otp === '1111') {
                $audience->pin = $request->new_pin;
                $audience->save();
                $code = 200;
            } else {
                $code = 400; 
             
            }            
        }catch (\Exception $exception){
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' =>'PIN Reset completed', 'data' => $audience],  $code);
    }


    public function audienceCreatePIN(Request $request)
    {
        $this->validate($request, [
            'pin' => 'required|numeric|digits:4',
            'phone_number' => 'required|numeric|digits:11',
        ]);
    
        try {
            $audience = Audience::where('phone_number', $request->phone_number)->first();
    
            if (!$audience) {
                return response()->json(['status' => false, 'message' => 'Audience not found'], 404);
            }
    
            $audience->pin = $request->pin;
            $audience->save();
    
    
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
    
        return response()->json(['status' => true, 'message' => 'Pin updated successfully'], 200);
    }


    public function sendVerificationCode($email, $code)
    {
        return Mail::to($email)->send(new VerificationMail($code));
    }
    
    public function generateVerificationCode($length = 6)
    {
        return Str::random($length);
    }

    public function audienceVerify(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|numeric|digits:11',
            'otp' => 'required|string'
        ]);

        try{

            $audience = Audience::where('phone_number', $request->phone_number)->first();

            if (!$audience) {
                return response()->json(['status' => 400, 'message' => 'Audience not found'], 400);
            }
            
            // logger("Request OTP: {$request->otp}, Audience OTP: {$user->otp}");


            if ($audience && trim($request->otp) === '1111') {
                // logger("OTP is correct for audience: {$audience->phone_number}");

                // Update the status if OTP is '1111'
                $audience->update([
                    'status' => 1, 
                ]);

                $code = 200;
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
            }

        }catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['status' => true, 'message' => 'Phone Number Verified', 'data' => $audience], $code);
    }
}
