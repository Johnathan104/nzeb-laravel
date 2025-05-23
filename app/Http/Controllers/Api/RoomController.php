<?php

namespace App\Http\Controllers\Api;
use App\Models\Room;
use App\Models\Issue;
use Illuminate\HttpRequest;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BuildingPart;
class RoomController extends Controller
{
    //
    public function addBuildingPart(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'type_id' => 'required|exists:building_parts,id',
            'name' => 'required'
        ]);

        $room = Room::find($validatedData['room_id']);
        $buildingPart = BuildingPart::find($validatedData['type_id']);

        if ($room && $buildingPart) {
            // Decode the existing building_parts JSON
            $buildingParts = json_decode($room->building_parts, true) ?? [];
    
            // Check if a part with the same name already exists in the array
            foreach ($buildingParts as $part) {
                if ($part['name'] === $validatedData['name']) {
                    return response()->json(['message' => 'A building part with the same name already exists in this room'], 422);
                }
            }
    
            // Create the new part
            $newPart = [
                'part_id' => $validatedData['type_id'],
                'type_id' => $buildingPart->id,
                'name' => $validatedData['name'],
            ];
    
            // Append the new part and save
            $buildingParts[] = $newPart;
            $room->building_parts = json_encode($buildingParts);
            $room->save();
    
            // Update the locations field in the building_part
            $locations = json_decode($buildingPart->locations, true) ?? [];
            if (!in_array($room->id, $locations)) {
                $locations[] = $room->id;
                $buildingPart->locations = json_encode($locations);
                $buildingPart->save();
            }
    
            return response()->json(['message' => 'Building part added successfully', 'room' => $room, 'building_part' => $buildingPart], 200);
        } else {
            return response()->json(['message' => 'Room or Building Part not found'], 404);
        }
    }
    public function getrooms()
    {
        $rooms = Room::all(); // Fetch all rooms from the database
        return response()->json($rooms); // Return the rooms as a JSON response
    }
    public function remove(AdminRequest $request)
    {
        $validatedData = $request->validated();
        $room = Room::find ($request->id);
        if($room){
            try {
                // Decode the building_parts JSON to get associated building parts
                $buildingParts = json_decode($room->building_parts, true) ?? [];
    
                // Loop through each building part and remove the room ID from its locations
                foreach ($buildingParts as $part) {
                    $buildingPart = BuildingPart::find($part['type_id']);
                    if ($buildingPart) {
                        $locations = json_decode($buildingPart->locations, true) ?? [];
                        if (($key = array_search($room->id, $locations)) !== false) {
                            unset($locations[$key]); // Remove the room ID from locations
                            $buildingPart->locations = json_encode(array_values($locations)); // Re-index the array
                            $buildingPart->save();
                        }
                    }
                }
    
                // Delete the room
                $room->delete();
    
                return response()->json(['message' => 'Room deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error deleting room: ' . $e->getMessage()], 500);
            }
        }else{
            return response()->json(['message' => 'Room not found'], 404);
        }
    }
    public function store(AdminRequest $request){
        $validatedData = $request->validated();
        $data = array_merge($request->all(), [
            'created_at' => now()->format('Y-m-d H:i:s'), // Ensure proper datetime format
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);
        // Ensure room_name is present
        if (empty($data['room_name'])) {
            return response()->json(['message' => $data], 422);
        }

        $room = Room::create($data);
        return response()->json($room, 201); // Return the created room as a JSON response
    }
    public function deletePart(Request $request)
    {
        $room_id = $request->input('room_id');
        $name = $request->input('name');
        $part_type_id = $request->input('part_type_id');

        $room = Room::find($room_id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $issues = Issue::where('room_id', $room_id)->where('part_name', $name)->get();

        if ($issues) {
            try {
                // Delete the issue
                foreach ($issues as $issue) {
                    $issue->delete();

                    // Find the associated building part
                    $buildingPart = BuildingPart::find($issue->part_type_id);
                    if ($buildingPart) {
                        // Decode the problems JSON
                        $problems = json_decode($buildingPart->problems, true) ?? [];

                        // Remove the issue from the problems array
                        $problems = array_filter($problems, function ($problem) use ($issue) {
                            return $problem['issue_id'] !== $issue->id;
                        });

                        // Save the updated problems array back to the building part
                        $buildingPart->problems = json_encode(array_values($problems)); // Re-index the array
                        $buildingPart->save();
                    }
                }
                
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Error deleting issue: ' . $th->getMessage()], 500);
            }
        }

        // Decode the existing building_parts JSON
        $buildingParts = json_decode($room->building_parts, true) ?? [];

        // Find the part to remove
        foreach ($buildingParts as $key => $part) {
            if ($part['name'] === $name) {
                unset($buildingParts[$key]);
                break;
            }
        }

        // Check if there are any more parts with the same part_type_id in the room
        $hasOtherParts = false;
        foreach ($buildingParts as $part) {
            if ($part['type_id'] == $part_type_id) {
                $hasOtherParts = true;
                break;
            }
        }

        // If no other parts with the same part_type_id exist, remove the room_id from the locations in the building part
        if (!$hasOtherParts) {
            $buildingPart = BuildingPart::find($part_type_id);
            if ($buildingPart) {
                $locations = json_decode($buildingPart->locations, true) ?? [];
                if (($key = array_search($room_id, $locations)) !== false) {
                    unset($locations[$key]); // Remove the room ID from locations
                    $buildingPart->locations = json_encode(array_values($locations)); // Re-index the array
                    $buildingPart->save();
                }
            }
        }

        // Save the updated building_parts JSON
        $room->building_parts = json_encode(array_values($buildingParts));
        $room->save();

        return response()->json(['message' => 'Building part removed successfully', 'room' => $room], 200);
    }
    public function edit(AdminRequest $request, $id){
        $validatedData = $request->validated();
        $room = Room::find($id);
        if(!$room){
            return response()->json(['message' => 'Room not found'], 404);
        }
        if($room){
            $data = array_merge($request->all(), [
                'updated_at' => now()->format('Y-m-d H:i:s'), // Ensure proper datetime format
            ]);
            $room->update($data);
            return response()->json(['message' => 'Room updated successfully', 'data'=>$data], 200);
        }
    }
    public function getroom(Request $request)
    {
        $room = Room::find($request->id);
        if($room){
            return response()->json($room);
        }else{
            return response()-> json(['message'=>'Room not found'], 404);
        }
    }
}
