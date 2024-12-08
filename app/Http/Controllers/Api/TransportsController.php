<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transports;
use App\Models\Destinations;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $transports = Transports::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Transport berhasil ditemukan.',
            'data' => $transports
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
            'nama_transport' => 'required|string|min:3|max:255',
            'tipe_transport' => 'required|in:bis,travel,pesawat,kapal',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        $transport = Transports::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Transport berhasil disimpan.',
            'data' => $transport
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
        $transport = Transports::with('destination')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Transport berhasil ditemukan.',
            'data' => $transport
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
            'nama_transport' => 'required|string|min:3|max:255',
            'tipe_transport' => 'required|in:bis,travel,pesawat,kapal',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        $transport = Transports::findOrFail($id);
        $transport->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data Transport berhasil diubah.',
            'data' => $transport
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
        $transport = Transports::findOrFail($id);
        $transport->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Transport berhasil dihapus.'
        ], 204);
    }
}
