<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyStoreRequest;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $companies = Company::all();

            $companyUser = CompanyUser::all();

        }  catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false, 'companyUser' => $companyUser, 'companies' => $companies, ], 200);

    }

    public function storeCompany(CompanyStoreRequest $request)
    {   
        try {
            // dd(auth()->id);
            $company = Company::create($request->validated());

            if ( isset($company->id) ) {
                $companyUser = CompanyUser::create([
                    'company_id' => $company->id,
                    'user_id' => 'f499401d-4cda-4bb1-93e4-3c19048f464b'
                ]);
            } else {
                echo "company not found";
            }
        //    dd($companyUser);

        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Company created successfully', 
                'data1' => $companyUser, 'data' => $company], 
                201);
    }
}
