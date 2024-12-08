<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotels;
use App\Models\Destinations;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelsController extends Controller
{
    /**
     * Display a listing of the hotels.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hotels =
            Hotels::all();

        return response()->json([
            'status' => true,
            'message' => 'Data hotels berhasil diambil.',
            'data' => $hotels
        ]);
    }

    /**
     * Store a newly created hotel in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'harga_per_malam' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        $hotel = Hotels::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Hotel berhasil ditambahkan.',
            'data' => $hotel
        ], 201);
    }

    /**
     * Display the specified hotel.
     *
     * @param  Hotels $hotel
     * @return JsonResponse
     */
    public function show(Hotels $hotel): JsonResponse
    {
        $hotel->load('destination'); // Memuat relasi dengan destination

        return response()->json([
            'status' => true,
            'message' => 'Data hotel berhasil diambil.',
            'data' => $hotel
        ]);
    }

    /**
     * Update the specified hotel in storage.
     *
     * @param  Request $request
     * @param  Hotels $hotel
     * @return JsonResponse
     */
    public function update(Request $request, Hotels $hotel): JsonResponse
    {
        $validator = $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'harga_per_malam' => 'required|numeric',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        $hotel->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Hotel berhasil diperbarui.',
            'data' => $hotel
        ]);
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param  Hotels $hotel
     * @return JsonResponse
     */
    public function destroy(Hotels $hotel): JsonResponse
    {
        $hotel->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hotel berhasil dihapus.'
        ], 200);
    }
}
