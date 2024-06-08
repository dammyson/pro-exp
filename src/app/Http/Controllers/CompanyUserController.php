<?php

namespace App\Http\Controllers;

use App\Models\CompanyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyUserController extends Controller
{
    //

    public function index(Request $request)
    {
        try {

            $companyUser = CompanyUser::all();

        }  catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false, 'companyUser' => $companyUser ], 200);

    }

    public function storeCompanyUser(Request $request)
    {   
        $request->validate([
            'company_id' => 'required',
            'user_id'=> 'required'
        ]);

        try {
           
            $companyUser = CompanyUser::create([
                'company_id' => $request->company_id,
                'user_id' => $request->user_id
            ]);

        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Company created successfully', 'data1' => $companyUser], 201);
    }
}
