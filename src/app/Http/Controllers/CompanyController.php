<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function index(Request $request): Response
    {
        $companies = Company::all();
    }

    public function store(CompanyStoreRequest $request): Response
    {
        $company = Company::create($request->validated());
    }
}
