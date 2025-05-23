<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Room;
use App\Models\BuildingPart;
use App\Models\Issue;

class IssueController extends Controller
{
    function getYourIssue(){
        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }
        $issues = Issue::where('user_id', $user->id)->get();
        if ($issues->isEmpty()) {
            return response()->json(['message' => 'No issues found for this user'], 204);
        }
        return response()->json($issues, 200);
    }
    function index()
    {
        $issues = Issue::all();
        return response()->json($issues);
    }
    function show($id)
    {
        $issue = Issue::find($id);
        if ($issue) {
            return response()->json($issue);
        } else {
            return response()->json(['message' => 'Issue Report not found'], 404);
        }
    }

    function store(Request $request)
    {
        // Check if the request has a valid token and retrieve the authenticated user
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'part_type_id' => 'required|exists:building_parts,id',
            'part_name' => 'required|string|max:255',
        ]);

        // Add the authenticated user to the validated data
        $validatedData['user_id'] = $user->id;

        // Find the associated building part
        $buildingPart = BuildingPart::find($request->part_type_id);
        if (!$buildingPart) {
            return response()->json(['message' => 'Building part not found'], 404);
        }

        $room = Room::find($request->room_id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        // Create the issue
        $issue = Issue::create($validatedData);

        // Decode the existing problems JSON column
        $problems = json_decode($buildingPart->problems, true) ?? [];

        // Add the new issue to the problems array
        $newProblem = [
            'issue_id' => $issue->id,
        ];
        $problems[] = $newProblem;

        // Save the updated problems array back to the building part
        $buildingPart->problems = json_encode($problems);
        $buildingPart->save();

        return response()->json($issue, 201);
    }

    function update(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'part_type_id' => 'required|exists:building_parts,id',
        ]);

        $issue = Issue::find($id);

        if (!$issue) {
            return response()->json(['message' => 'Issue not found'], 404);
        }

        // Check if the user is an admin or the owner of the issue
        if (!$user->isAdmin && $issue->user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized: You do not have permission to update this issue'], 403);
        }

        // Update the issue with the validated data
        $issue->update($validatedData);

        // Update the associated building part's problems array
        $buildingPart = BuildingPart::find($validatedData['part_type_id']);
        if ($buildingPart) {
            $problems = json_decode($buildingPart->problems, true) ?? [];

            // Update the problem entry for this issue
            foreach ($problems as &$problem) {
                if ($problem['issue_id'] == $issue->id) {
                    $problem['name'] = $validatedData['name'];
                    $problem['description'] = $validatedData['description'];
                    break;
                }
            }

            $buildingPart->problems = json_encode($problems);
            $buildingPart->save();
        }

        return response()->json(['message' => 'Issue updated successfully', 'issue' => $issue], 200);
    }

    function remove(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'part_type_id' => 'required|exists:building_parts,id',
        ]);
        $issue = Issue::find($id);
        if(!$user.isAdmin ==1){
            return response()->json(['message' => 'Unauthorized: You do not have permission to delete this issue'], 403);
        }
        if ($issue.user_id != $user->id) {
            return response()->json(['message' => 'Unauthorized: You do not have permission to delete this issue'], 403);
        }
        if ($issue) {
            // Find the associated building part
            $buildingPart = BuildingPart::find($issue->part_type_id);
            if (!$buildingPart) {
                return response()->json(['message' => 'Building part not found'], 404);
            }
            // Decode the existing problems JSON column
            $problems = json_decode($buildingPart->problems, true) ?? [];

            // Remove the issue from the problems array
            foreach ($problems as $key => $problem) {
                if ($problem['issue_id'] == $issue->id) {
                    unset($problems[$key]);
                    break;
                }
            }

            // Save the updated problems array back to the building part
            $buildingPart->problems = json_encode(array_values($problems));
            $buildingPart->save();

            // Delete the issue
            $issue->delete();
            return response()->json(['message' => 'Issue deleted successfully']);
        } else {
            return response()->json(['message' => 'Issue not found'], 404);
        }
    }
}
