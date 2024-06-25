<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignVoucherRewardController extends Controller
{
    //
    public function upload(Request $request) 
    {
        $validated = $this->validate($request, [
            'vouchers' => 'required|file|mimes:xls,xlsx|max:1024'
        ]);

        /*
        try {
            // $import = new UploadPregeneratedVoucher($campaign_id);
            // Excel::import($import, request()->file('vouchers'));

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            report($e);
            return response()->json($e->failures(), 400);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => "unable to upload vouchers"], 500);
        }

        return response()->json(['error' => false, 'message' => "vouchers uploaded"]);
        */
    }
}
