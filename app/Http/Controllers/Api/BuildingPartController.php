<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BuildingPart;
use Illuminate\Http\Request;

class BuildingPartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildingParts = BuildingPart::all();
        return response()->json($buildingParts);
    }

    /**
     * Get all building parts.
     */

    public function getPart($id){
        $buildingPart = BuildingPart::find($id);
        if(!$buildingPart){
            return response()->json(['message'=> 'Building part not found'], 404);
        }
        return response()->json(['data'=> $buildingPart], 200);
    }
    public function getAll()
    {
        $buildingParts = BuildingPart::all();
        return response()->json($buildingParts);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'class' => 'required|string|max:255', // Class is required
            'type' => 'required|string|max:255', // Type is required
            'pemeriksaan' => 'required|string|max:255',
            'pemeliharaan' => 'required|string|max:255',
            'perawatan' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255', // URL is optional
            'locations' => 'required|array',    // Ensure locations is an array
            'problems' => 'required|array',     // Ensure problems is an array
        ]);

        $buildingPart = BuildingPart::create($validatedData);

        return response()->json($buildingPart, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buildingPart = BuildingPart::find($id);

        if (!$buildingPart) {
            return response()->json(['message' => 'Building part not found'], 404);
        }

        return response()->json($buildingPart);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buildingPart = BuildingPart::find($id);

        if (!$buildingPart) {
            return response()->json(['message' => 'Building part not found'], 404);
        }

        $validatedData = $request->validate([
            'class' => 'sometimes|required|string|max:255', // Class is optional
            'type' => 'sometimes|required|string|max:255',  // Type is optional
            'pemeriksaan' => 'sometimes|required|string|max:255',
            'pemeliharaan' => 'sometimes|required|string|max:255',
            'perawatan' => 'sometimes|required|string|max:255',
            'title' => 'sometimes|required|string|max:255',
            'url' => 'nullable|string|max:255', // URL is optional
            'locations' => 'sometimes|required|array',      // Ensure locations is an array
            'problems' => 'sometimes|required|array',       // Ensure problems is an array
        ]);

        $buildingPart->update($validatedData);

        return response()->json($buildingPart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buildingPart = BuildingPart::find($id);

        if (!$buildingPart) {
            return response()->json(['message' => 'Building part not found'], 404);
        }

        $buildingPart->delete();

        return response()->json(['message' => 'Building part deleted successfully']);
    }
}
