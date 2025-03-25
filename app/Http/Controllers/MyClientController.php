<?php

namespace App\Http\Controllers;

use App\Models\MyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MyClientController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:250',
            'slug' => 'required|string|max:100|unique:my_client',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload to S3
        if ($request->hasFile('client_logo')) {
            $path = $request->file('client_logo')->store('logos', 's3');
            $clientLogoUrl = Storage::disk('s3')->url($path);
        } else {
            $clientLogoUrl = 'no-image.jpg'; // Default image
        }

        // Create client with logo URL
        $client = MyClient::create(array_merge($request->all(), ['client_logo' => $clientLogoUrl]));
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
        Redis::del($slug); // Delete existing Redis entry
        Redis::set($client->slug, json_encode($client)); // Generate new Redis entry
        return response()->json($client);
    }

    public function delete($slug)
    {
        $client = MyClient::where('slug', $slug)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete(); // Soft delete
        Redis::del($slug); // Delete Redis entry
        return response()->json(['message' => 'Client deleted successfully']);
    }
}