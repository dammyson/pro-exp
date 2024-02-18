<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    public function index(Request $request): Response
    {
        $clients = Client::all();
    }

    public function store(ClientStoreRequest $request): Response
    {
        $client = Client::create($request->validated());
    }
}
