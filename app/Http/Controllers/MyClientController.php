<?php

namespace App\Http\Controllers;

use App\Models\MyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MyClientController extends Controller
{
    public function create(Request $request)
    {
        $client = MyClient::create($request->all());
        Redis::set($client->slug, json_encode($client));
        return response()->json($client, 201);
    }

    public function read($slug)
    {
        $client = Redis::get($slug);
        if ($client) {
            return response()->json(json_decode($client));
        }

        $client = MyClient::where('slug', $slug)->first();
        if ($client) {
            Redis::set($client->slug, json_encode($client));
            return response()->json($client);
        }

        return response()->json(['message' => 'Client not found'], 404);
    }

    public function update(Request $request, $slug)
    {
        $client = MyClient::where('slug', $slug)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->update($request->all());
        Redis::set($client->slug, json_encode($client));
        return response()->json($client);
    }

    public function delete($slug)
    {
        $client = MyClient::where('slug', $slug)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();
        Redis::del($slug);
        return response()->json(['message' => 'Client deleted successfully']);
    }
}