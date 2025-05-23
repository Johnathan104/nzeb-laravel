<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Http\Requests\AdminRequest;
class MaintenanceController extends Controller
{
    //
    public function getallMaintenances(AdminRequest $request){
        $maintenances = Maintenance::all(); // Fetch all rooms from the database
        return response()->json($maintenances); // Return the rooms as a JSON response
    }
    public function deleteMaintenance(Request $request){
        $user = auth()->user();

        if(!$user){
            return response()->json(['message'=>'Unauthorized'], 401);
        }
        
        $maintenance = Maintenance::find($request->id);
        if($user->isAdmin != 1 || $maintenance->pemohon != $user->email){
            return response()->json(['message'=>'Unauthorized'], 401);
        }
        
        if($maintenance){
            $maintenance->delete();
            return response()->json(['message'=>'Maintenance record deleted successfully']);
        }else{
            return response()-> json(['message'=>'Maintenance record not found'], 404);
        }
    }
    public function acceptMaintenance(AdminRequest $request){
        $maintenance = Maintenance::find($request->id);
        if($maintenance){
            if($maintenance->status == 'selesai'){
                return response()->json(['message'=>'Maintenance sudah selesai'], 400);
            }
            $maintenance->update(['status'=>'dijalankan']);
            return response()->json(['message'=>'Maintenance  telah diterima']);
        }else{
            return response()-> json(['message'=>'Maintenance tidak ditemukan'], 404);
        }
    }
    public function getYourMaintenance(Request $request){
        $user = auth()->user();
        if(!$user){
            return response()->json(['message'=>'Unauthorized'], 401);
        }
        $maintenances = Maintenance::where('pemohon', $user->email)->get();
        return response()->json($maintenances);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'routine' => 'required|string|max:255',
            'room_id' => 'nullable|exists:rooms,id', // Ensure the room exists
            'pelaksana' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'safety_helmet' => 'boolean',
            'safety_vest' => 'boolean',
            'safety_shoes' => 'boolean',
            'gloves' => 'boolean',
            'mask' => 'boolean',
            'pemohon' => 'string|max:255',
            'full_body_harness' => 'boolean',
            'work_steps' => 'nullable|string',
            'hazards' => 'nullable|string',
            'mitigation' => 'nullable|string',
            'status' => 'nullable|string|in:diproses,selesai,dibatalkan', // Example statuses
        ]);
        $validatedData['pemohon'] = auth()->user()->email;
        // Create a new maintenance record
        $maintenance = Maintenance::create($validatedData);

        // Return a success response
        return response()->json([
            'message' => 'Maintenance record created successfully',
            'data' => $maintenance,
        ], 201);
    }
}
