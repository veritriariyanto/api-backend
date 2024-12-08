<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DestinationsController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil semua destinasi dengan paginasi
        $destinations = Destinations::all();

        return response()->json([
            'status' => true,
            'message' => 'Data destinasi berhasil diambil',
            'data' => $destinations
        ], 200);
    }

    /**
     * store
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama_destinasi' => 'required|string|min:3',
            'deskripsi'     => 'required|string|min:10',
            'lokasi'        => 'required|string|max:255',
            'htm'           => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/destinations/', $image->hashName());

        // Simpan data destinasi
        $destination = Destinations::create([
            'image'         => $image->hashName(),
            'nama_destinasi' => $request->nama_destinasi,
            'deskripsi'     => $request->deskripsi,
            'lokasi'        => $request->lokasi,
            'htm'           => $request->htm
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data destinasi berhasil disimpan',
            'data' => $destination
        ], 201);
    }

    /**
     * show
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        // Cari destinasi berdasarkan ID
        $destination = Destinations::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data destinasi berhasil ditemukan',
            'data' => $destination
        ], 200);
    }

    /**
     * update
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama_destinasi' => 'required|string|min:3',
            'deskripsi'     => 'required|string|min:10',
            'lokasi'        => 'required|string|max:255',
            'htm'           => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari destinasi berdasarkan ID
        $destination = Destinations::findOrFail($id);

        // Periksa jika ada gambar baru
        if ($request->hasFile('image')) {
            // Upload gambar baru
            $image = $request->file('image');
            $image->storeAs('public/destinations/', $image->hashName());

            // Hapus gambar lama
            Storage::delete('public/destinations/' . $destination->image);

            // Update dengan gambar baru
            $destination->update([
                'image'         => $image->hashName(),
                'nama_destinasi' => $request->nama_destinasi,
                'deskripsi'     => $request->deskripsi,
                'lokasi'        => $request->lokasi,
                'htm'           => $request->htm
            ]);
        } else {
            // Update tanpa mengganti gambar
            $destination->update($request->only('nama_destinasi', 'deskripsi', 'lokasi', 'htm'));
        }

        return response()->json([
            'status' => true,
            'message' => 'Data destinasi berhasil diubah',
            'data' => $destination
        ], 200);
    }

    /**
     * destroy
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        // Cari destinasi berdasarkan ID
        $destination = Destinations::findOrFail($id);

        // Hapus gambar
        Storage::delete('public/destinations/' . $destination->image);

        // Hapus data destinasi
        $destination->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data destinasi berhasil dihapus'
        ], 200);
    }
}