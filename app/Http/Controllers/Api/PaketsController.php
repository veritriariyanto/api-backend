<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pakets;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pakets = Pakets::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Paket berhasil ditemukan.',
            'data' => $pakets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_total' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id' => 'required|exists:hotels,id',
            'transport_id' => 'required|exists:transports,id',
            'rating' => 'nullable|integer|min:0|max:5',
            'ulasan' => 'nullable|integer|min:0',
            'total_pembelian' => 'nullable|integer|min:0',
        ]);

        $paket = Pakets::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Paket berhasil disimpan.',
            'data' => $paket
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $paket = Pakets::with(['destination', 'hotel', 'transport'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Paket berhasil ditemukan.',
            'data' => $paket
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_total' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id' => 'required|exists:hotels,id',
            'transport_id' => 'required|exists:transports,id',
            'rating' => 'nullable|integer|min:0|max:5',
            'ulasan' => 'nullable|integer|min:0',
            'total_pembelian' => 'nullable|integer|min:0',
        ]);

        $paket = Pakets::findOrFail($id);
        $paket->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Paket berhasil diubah.',
            'data' => $paket
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $paket = Pakets::findOrFail($id);
        $paket->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Paket berhasil dihapus.'
        ], 204);
    }
}
