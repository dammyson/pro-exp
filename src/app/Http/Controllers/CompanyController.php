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
            // dd(auth()->user());
            $company = Company::create($request->validated());

            if ( isset($company->id)) {
                $companyUser = CompanyUser::create([
                    'company_id' => $company->id,
                    'user_id' => '8152ed5d-0f1c-4682-8bce-8eb0a7e00b96'
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
