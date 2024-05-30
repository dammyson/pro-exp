<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        try {
            $brands = Brand::all();

        }  catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false,  'data' => $brands], 200);
    }

    public function storeBrand(BrandStoreRequest $request)
    {
        try{
            $brand = Brand::create($request->validated());

        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false,  'message' => 'Brand created successfully', 'data' => $brand], 201);
        }
}
