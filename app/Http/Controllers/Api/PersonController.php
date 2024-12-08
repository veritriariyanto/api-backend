<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\person;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    public function index()
    {
        $person = Person::all();
        return response()->json([
            'status' => true,
            'messange' => 'data berhasil ditemukan',
            'data' => $person
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messange' => 'validasi error',
                'errors' => $validator->errors()
            ], 422);
        }
        $person = Person::create($request->all());
        return response()->json([
            'status' => true,
            'messange' => 'data berhasil dimasukan',
            'data' => $person
        ], 201);
    }
    public function show(string $id)
    {
        $person = Person::findOrFail($id);
        return response()->json([
            'status' => 'true',
            'message' => 'data berhasil ditemukan',
            'data' => $person
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'true',
                'message' => 'data berhasil ditemukan',
                'errors' => $validator->errors()
            ], 422);
        }
        $person = Person::findOrFail($id);
        $person->update($request->all());
        return response()->json([
            'status' => 'true',
            'message' => 'data berhasil ditemukan',
            'data' => $person
        ], 200);
    }
    public function destroy(string $id)
    {
        $person = person::findOrFail($id);
        $person->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'data berhasil dihapus',
        ], 204);
    }
}