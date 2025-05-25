<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Models\BuildingPart;

class RoomController extends Controller
{
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
            $buildingParts = json_decode($room->building_parts, true) ?? [];

            foreach ($buildingParts as $part) {
                if ($part['name'] === $validatedData['name']) {
                    return response()->json(['message' => 'A building part with the same name already exists in this room'], 422);
                }
            }

            $newPart = [
                'part_id' => $validatedData['type_id'],
                'type_id' => $buildingPart->id,
                'name' => $validatedData['name'],
            ];

            $buildingParts[] = $newPart;
            $room->building_parts = json_encode($buildingParts);
            $room->save();

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
        $room = Room::find($request->id);
        if ($room) {
            try {
                $buildingParts = json_decode($room->building_parts, true) ?? [];

                foreach ($buildingParts as $part) {
                    $buildingPart = BuildingPart::find($part['type_id']);
                    if ($buildingPart) {
                        $locations = json_decode($buildingPart->locations, true) ?? [];
                        if (($key = array_search($room->id, $locations)) !== false) {
                            unset($locations[$key]);
                            $buildingPart->locations = json_encode(array_values($locations));
                            $buildingPart->save();
                        }
                    }
                }

                $room->delete();

                return response()->json(['message' => 'Room deleted successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error deleting room: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Room not found'], 404);
        }
    }

    public function store(AdminRequest $request)
    {
        $validatedData = $request->validated();
        $data = array_merge($request->all(), [
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
            'lighting' => $request->input('lighting', 0), // Default to 0 if not provided
            'energy' => $request->input('energy', 0),     // Default to 0 if not provided
        ]);

        if (empty($data['room_name'])) {
            return response()->json(['message' => 'Room name is required'], 422);
        }

        $room = Room::create($data);
        return response()->json($room, 201);
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
                foreach ($issues as $issue) {
                    $issue->delete();

                    $buildingPart = BuildingPart::find($issue->part_type_id);
                    if ($buildingPart) {
                        $problems = json_decode($buildingPart->problems, true) ?? [];

                        $problems = array_filter($problems, function ($problem) use ($issue) {
                            return $problem['issue_id'] !== $issue->id;
                        });

                        $buildingPart->problems = json_encode(array_values($problems));
                        $buildingPart->save();
                    }
                }
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Error deleting issue: ' . $th->getMessage()], 500);
            }
        }

        $buildingParts = json_decode($room->building_parts, true) ?? [];

        foreach ($buildingParts as $key => $part) {
            if ($part['name'] === $name) {
                unset($buildingParts[$key]);
                break;
            }
        }

        $hasOtherParts = false;
        foreach ($buildingParts as $part) {
            if ($part['type_id'] == $part_type_id) {
                $hasOtherParts = true;
                break;
            }
        }

        if (!$hasOtherParts) {
            $buildingPart = BuildingPart::find($part_type_id);
            if ($buildingPart) {
                $locations = json_decode($buildingPart->locations, true) ?? [];
                if (($key = array_search($room_id, $locations)) !== false) {
                    unset($locations[$key]);
                    $buildingPart->locations = json_encode(array_values($locations));
                    $buildingPart->save();
                }
            }
        }

        $room->building_parts = json_encode(array_values($buildingParts));
        $room->save();

        return response()->json(['message' => 'Building part removed successfully', 'room' => $room], 200);
    }

    public function edit(AdminRequest $request, $id)
    {
        $validatedData = $request->validated();
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $data = array_merge($request->all(), [
            'updated_at' => now()->format('Y-m-d H:i:s'),
            'lighting' => $request->input('lighting', $room->lighting), // Keep existing value if not provided
            'energy' => $request->input('energy', $room->energy),       // Keep existing value if not provided
        ]);

        $room->update($data);
        return response()->json(['message' => 'Room updated successfully', 'data' => $data], 200);
    }

    public function getroom(Request $request)
    {
        $room = Room::find($request->id);
        if ($room) {
            return response()->json($room);
        } else {
            return response()->json(['message' => 'Room not found'], 404);
        }
    }
}
