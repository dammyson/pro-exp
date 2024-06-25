<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CampaignSpinWheelReward;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    //
    public function AirtimeRewards($audience_id)
    {
        try {
            $data = CampaignSpinWheelReward::where('audience_id', $audience_id)
                        ->where('type', 'AIRTIME')->get(); // ->where('is_redeemed', false)->get();
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500);
        }
        return response()->json([
            'error' => false, 
            'message' => 'Airtime Rewards',
            'data' => $data
        ]);
    }

    public function redeemAirtime(Request $request, $audience_id) 
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|digits:11'
        ]);
        
        try {
            
            $getAllTotalUnredeemedAirtime = CampaignSpinWheelReward::where('audience_id', $audience_id)
                ->where('is_redeem', false)->where('type', 'AIRTIME')->get();
            $phone = '+234'.substr($validated['phone'], 1);
            $value = $getAllTotalUnredeemedAirtime->sum('value');

            if ($value > 0) {
                $type = 'AIRTIME';
                $data = $this->sendValue($phone, $value, $type);  // sends airtime to user
                if ($data['status'] != 'success') {
                    return response()->json(['error' => true, 'message' => 'An Error occured from Provider'], 400);
                }

                $response = $this->validateAirtimeReward($validated['phone']);
                if ($response['data']['response_code'] !== '00') {
                    return response()->json([
                        'error' => true,
                        'message' => 'An error occured from Provider'
                    ], 400);
                }

                foreach ($getAllTotalUnredeemedAirtime as $redeemed) 
                {
                    $redeemed->is_redeem = true;
                    $redeemed->save();
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Your airtime reward has been exhausted"
                ], 400);
            }

        } catch (\Throwable $throwable) {
            report($throwable);
            return response()->json([
                'status' => false,
                'message' => $throwable->getMessage()
            ], 500);
        }

        return response()->json([$data], 200);
    }

    // Data bundle
    public function DataBundleRewards($audience_id) 
    {
        try {
            $data = CampaignSpinWheelReward::where('audience_id', $audience_id)
                        ->where('type', 'DATA')->get(); // ->where('is_redeem', false)->get();
        } catch (\Throwable $throwable){
            report($throwable);
            return response()->json(['status' => false, 'message' => $throwable->getMessage()], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Databundle Rewards',
            'data' => $data
        ]);
    }

    public function redeemDatabundleMTN(Request $request, $audience_id)
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|digits:11'
        ]);

        try {
            $dataBundle = CampaignSpinWheelReward::where('audience_id', $audience_id)
                ->where('is_redeem', false)->where('type', 'DATA')
                ->orderBy('created_at', 'desc')->first();

            if ($dataBundle == null) 
            {
                return response()->json([
                    'error' => true,
                    'message' => 'Data Bundle available for you at the moment'
                ], 400);
            }
            $billerCode = 'BIL104';
            $itemCode = 'MD104';
            //dd($this->listBills($billerCode));

            $type = "MTN 50 MB";
            $amount = "100";
            $phone = '+234'.substr($validated['phone'], 1);
            $this->sendValue($phone, $amount, $type);
            $validateData = $this->validateDataReward($validated['phone'], $billerCode, $itemCode);

            if ($validateData['data']['response_code'] != '00') 
            {
                return response()->json(
                    [
                        'error' => true,
                        'message' => 'An Error occured from Provider'
                    ], 400
                );
            }

            $dataBundle->is_redeem = true;
            $dataBundle->save();
        } catch (\Exception $exception) {
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json([
            $validateData
        ], 200);
        //json_decode($dataBundle->getBody()->getContents(), true);
    }

    public function redeemDatabundleAIRTEL(Request $request, $audience_id)
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|digits:11',
        ]);

        try {
            $dataBundle = CampaignSpinWheelReward::where('audience_id', $audience_id)
                ->where('is_redeem', false)
                ->where('type', 'DATA')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($dataBundle == null) 
            {
                return response()->json([
                    'error' => true,
                    'message' => 'No Data Bundle available for you at the moment'
                ], 400);
            }

            $billerCode = 'BIL106';
            $itemCode = 'MD116';

            $type = "AIRTEL 10MB data bundle";
            $amount = "50";
            $phone = '+234' .substr($validated['phone'], 1);
            $this->sendValue($phone, $amount, $type);
            $validateData = $this->validateDataReward($validated['phone'], $billerCode, $itemCode);

            if ($validateData['data']['response_code'] != '00')
            {
                return response()->json(
                    [
                        'error' => true,
                        'message' => 'An Error occured from Provider'
                    ], 400
                );
            }

            $dataBundle->is_redeem = true;
            $dataBundle->save();

        } catch (\Throwable $throwable){
            return response()->json(['status' => false, 'message' => $throwable->getMessage()], 500);
        }

        return response()->json([$validateData], 200);
    }

    public function GLO(Request $request, $audience_id)
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|digits:11'
        ]);

        try {
            $dataBundle = CampaignSpinWheelReward::where('audience_id', $audience_id)
                ->where('is_redeem', false)->where('type', 'DATA')->orderBy('created_at', 'desc')->first();
        
            if ($dataBundle == null)
            {
                return response()->json([
                    'error' => true,
                    'message' => 'No Data Bundle available for you at the moment'
                ], 400);
            }

            $billerCode = 'BIL105';
            $itemCode = 'MD110';

            $type = "GLO 35 MB data bundle";
            $amount = "100";
            $phone = '+234'.substr($validated['phone'], 1);
            $this->sendValue($phone, $amount, $type);
            $validateData = $this->validateDataReward($validated['phone'], $billerCode, $itemCode);
            if ($validateData['data']['response_code'] != '00')
            {
                return response()->json([
                    'error' => true,
                    'message' => 'An Error occured from Provider'
                ], 400);
            }

            $dataBundle->is_redeem = true;
            $dataBundle->save();
        
        } catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }

        return response()->json([$validateData], 200);
    }

    public function MOBILE(Request $request, $audience_id)
    {
        $validated = $this->validate($request, [
            'phone' => 'required|numeric|digits:11'
        ]);

        try {
            $dataBundle = CampaignSpinWheelReward::where('audience_id', $audience_id)
                ->where('is_redeem', false)->where('type', 'DATA')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($dataBundle == null) {
                return response()->json([
                    'error' => true,
                    'message' => 'No Data Bundle available for you at the moment'
                ], 400);
            }

            $billerCode = 'BIL107';
            $itemCode = 'MD127';
            $type = "9MOBILE 150MB data bundle";
            $amount = "200";
            $phone = '+234'.substr($validated['phone'], 1);

            $this->sendValue($phone, $amount, $type);
            $validateData = $this->validateDataReward($validated['phone'], $billerCode, $itemCode);
            if ($validateData['data']['response_code'] != '00')
            {
                return response()->json([
                    'error' => true,
                    'message' => 'An Error occured from provider'
                ], 400);
            }
            
            $dataBundle->is_redeem = true;
            $dataBundle->save();
    

        } catch (\Throwable $throwable){
            return response()->json(['status' => false, 'message' => $throwable->getMessage()], 500);
        }
        
        return response()->json([$validateData], 200);
    }

    // List categories
    public function listBills($billerCode)
    {
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' .env('FLUTTERWAVE_KEY')
            ])->get(env('FLUTTERWAVE_BASE_URL').'/bill-categories'); //?biller_code='$billerCode);
        
        } catch (\Throwable $throwable){
            return response()->json(['status' => false, 'message' => $throwable->getMessage()], 500);
        }

        return $response = json_decode($res->getBody()->getContents(), true);
    }

    // value Handler 
    public function sendValue($phone, $amount, $type)
    {
        try {
            $res = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.env('FLUTTERWAVE_KEY')
            ])->post(env('FLUTTERWAVE_BASE_URL'). '/bills', [
                "country" => "NG",
                "customer" => $phone,
                "amount" => $amount,
                "recurrence" => "ONCE",
                "type" => $type,
                "reference" => Str::random(10)
            ]);
        } catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }

        return $response = json_decode($res->getBody()->getContents(), true);
    }

    public function validateAirtimeReward($phone)
    {
        try {
            $data = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.env('FLUTTERWAVE_KEY')
            ])->get(env('FLUTTERWAVE_BASE_URL').'/bill-items/AT099/validate?code=BIL099&customer='.$phone);
        } catch (\Throwable $throwable)
        {
            return response()->json(['error' => true, 'message' => $throwable->getMessage()], 500);
        }
        return json_decode($data->getBody()->getContents(), true);
    }

    public function validateDataReward($phone, $billerCode, $itemCode)
    {
        try {
            $data = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' .env('FLUTTERWAVE_KEY')
            ])->get(env('FLUTTERWAVE_BASE_URL').'/bill-items/'.$itemCode.'/validate?code='.$billerCode. '&customer='.$phone);
        } catch (\Throwable $throwable)
        {
            return response()->json(['error' => true, 'message' => $throwable->getMessage()], 500);
        }

        return json_decode($data->getBody()->getContents(), true);
    }
}
