<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    // public function index(Request $request): Response
    public function index(Request $request)
    {
        try {
            $clients = Client::all();

        }  catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false,  'data' => $clients], 200);
    }

    // public function store(ClientStoreRequest $request): Response
    public function storeClient(ClientStoreRequest $request)
    {
        try {
            $client = Client::create($request->validated());

        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
        return response()->json(['error' => false,  'message' => 'Client created successfully', 'data' => $client], 201);
    }
}
