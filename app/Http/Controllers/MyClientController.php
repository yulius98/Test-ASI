<?php

namespace App\Http\Controllers;

use App\Models\MyClient;
use App\Http\Requests\StoreMyClientRequest;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MyClientController extends Controller
{
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

    public function update(StoreMyClientRequest $request, $slug)
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


    private function updateEnvFile(array $data)
    {
    $envPath = base_path('.env');
    $envContent = File::get($envPath);

    foreach ($data as $key => $value) {
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
    }

    File::put($envPath, $envContent);
    }

    public function create(StoreMyClientRequest $request)
    {
            // Handle AWS credentials
            $awsAccessKeyId = $request->input('aws_access_key_id');
            $awsSecretAccessKey = $request->input('aws_secret_access_key');
            $awsBucket = $request->input('aws_bucket');

            // Update .env file with AWS credentials
            $this->updateEnvFile([
                'AWS_ACCESS_KEY_ID' => $awsAccessKeyId,
                'AWS_SECRET_ACCESS_KEY' => $awsSecretAccessKey,
                'AWS_BUCKET' => $awsBucket,
                'FILESYSTEM_DISK' => 's3',
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
    
    public function create()
    {
        return view('my_client.create'); // Return the create view
    }

    
}