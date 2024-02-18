<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index(Request $request): Response
    {
        $brands = Brand::all();
    }

    public function store(BrandStoreRequest $request): Response
    {
        $brand = Brand::create($request->validated());
    }
}
