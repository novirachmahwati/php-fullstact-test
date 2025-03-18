<?php

namespace App\Http\Controllers;

use App\Models\MyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MyClientController extends Controller
{
    // Menampilkan semua data yang belum dihapus secara soft delete
    public function index()
    {
        $clients = MyClient::whereNull('deleted_at')->get();
        return response()->json($clients);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        // Validasi data 
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'slug' => 'required|string|max:100|unique:my_client',
            'is_project' => 'required|in:0,1',
            'self_capture' => 'required|string|max:1',
            'client_prefix' => 'required|string|max:4',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
        ]);

        // Menangani upload gambar logo jika ada
        if ($request->hasFile('client_logo')) {
            $path = $request->file('client_logo')->store('logos', 's3');
            $validated['client_logo'] = Storage::disk('s3')->url($path);
        }

        // Membuat data baru
        $client = MyClient::create($validated);

        // Menyimpan data ke dalam cache Redis
        Redis::set("client:{$client->slug}", json_encode($client));

        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data' => $client
        ], 201);
    }

    // Menampilkan data berdasarkan ID
    public function show($id)
    {
        $client = MyClient::find($id);

        // Jika data ditemukan, kembalikan; jika tidak, beri pesan error
        if ($client) {
            return response()->json($client);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // Memperbarui data berdasarkan ID
    public function update(Request $request, $id)
    {
        $client = MyClient::findOrFail($id);

        // Validasi data 
        $validated = $request->validate([
            'name' => 'string|max:250',
            'slug' => "string|max:100|unique:my_client,slug,{$id}",
            'is_project' => 'in:0,1',
            'self_capture' => 'string|max:1',
            'client_prefix' => 'string|max:4',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
        ]);

        // Menangani upload gambar logo baru jika ada
        if ($request->hasFile('client_logo')) {
            $path = $request->file('client_logo')->store('logos', 's3');
            $validated['client_logo'] = Storage::disk('s3')->url($path);
        }

        // Memperbarui data
        $client->update($validated);

        // Menghapus data lama dari cache Redis dan memperbarui cache
        Redis::del("client:{$client->slug}");
        Redis::set("client:{$client->slug}", json_encode($client));

        return response()->json([
            'message' => 'Data berhasil diupdate.',
            'data' => $client
        ]);
    }

    // Menghapus data dengan soft delete
    public function destroy($id)
    {
        $client = MyClient::findOrFail($id);
        $client->update(['deleted_at' => now()]);
        
        // Menghapus data dari cache Redis
        Redis::del("client:{$client->slug}");

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
