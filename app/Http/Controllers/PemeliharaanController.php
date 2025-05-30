<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeliharaan;

class PemeliharaanController extends Controller
{
    /**
     * Display a listing of the pemeliharaan records.
     */
    public function index()
    {
        $pemeliharaan = Pemeliharaan::with(['room', 'user', 'issue', 'buildingPart'])->get();
        return response()->json($pemeliharaan, 200);
    }

    /**
     * Store a newly created pemeliharaan record in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }
        $validatedData = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'issue_id' => 'nullable|exists:issues,id',
            'part_type_id' => 'nullable|exists:building_parts,id',
            'jenis_pemeliharaan' => 'required|in:rutin,korektif,darurat',
            'kondisi' => 'required|in:baik,cukup,buruk',
            'keterangan' => 'required|string|max:255',
            'durasi' => 'required|string|max:255',
            'estimasi' => 'required|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'tanggal_pemohonan' => 'nullable|date',
            'nama_petugas' => 'nullable|string|max:255',
        ]);
        $validatedData['user_id'] = $user->id; // Set the authenticated user ID
        $validatedData['status'] = 'pending';
        $pemeliharaan = Pemeliharaan::create($validatedData);

        return response()->json(['message' => 'Pemeliharaan created successfully', 'pemeliharaan' => $pemeliharaan], 201);
    }

    /**
     * Update the specified pemeliharaan record in storage.
     */
    public function update(Request $request, $id)
    {
        $pemeliharaan = Pemeliharaan::find($id);

        if (!$pemeliharaan) {
            return response()->json(['message' => 'Pemeliharaan not found'], 404);
        }

        $validatedData = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'issue_id' => 'nullable|exists:issues,id',
            'part_type_id' => 'nullable|exists:building_parts,id',
            'jenis_pemeliharaan' => 'required|in:rutin,korektif,darurat',
            'kondisi' => 'required|in:baik,cukup,buruk',
            'keterangan' => 'required|string|max:255',
            'durasi' => 'required|string|max:255',
            'estimasi' => 'required|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'tanggal_pemohonan' => 'nullable|date',
            'nama_petugas' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in-progress,closed,resolved,on-hiatus', // Added status field
        ]);

        $pemeliharaan->update($validatedData);

        return response()->json(['message' => 'Pemeliharaan updated successfully', 'pemeliharaan' => $pemeliharaan], 200);
    }

    /**
     * Remove the specified pemeliharaan record from storage.
     */
    public function delete($id)
    {
        $pemeliharaan = Pemeliharaan::find($id);

        if (!$pemeliharaan) {
            return response()->json(['message' => 'Pemeliharaan not found'], 404);
        }

        $pemeliharaan->delete();

        return response()->json(['message' => 'Pemeliharaan deleted successfully'], 200);
    }
}
