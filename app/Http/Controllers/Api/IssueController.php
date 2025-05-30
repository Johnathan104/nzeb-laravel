<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\BuildingPart;
use App\Models\Issue;

class IssueController extends Controller
{
    public function getByPart($id)
    {
        $issues = Issue::where('part_type_id', $id)->get();
        if ($issues->isEmpty()) {
            return response()->json(['message' => 'No issues found for this type'], 204);
        }
        return response()->json($issues, 200);
    }

    function getYourIssue()
    {
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
        $issues = Issue::with(['buildingPart', 'check'])->get();
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
            'status' => 'required|string|in:pending',
            'room_id' => 'required|exists:rooms,id',
            'part_type_id' => 'required|exists:building_parts,id',
            'part_name' => 'required|string|max:255',
            'check_id' => 'required|exists:checks,id',
            'mode_kegagalan' => 'required|string|max:255', // New field
            'severity' => 'required|string|max:10', // Changed to string
            'occurrence' => 'required|string|max:10', // Changed to string
            'detection' => 'required|string|max:10', // Changed to string
            'rekomendasi_tindakan' => 'nullable|string|max:255', // New field
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
            'status' => 'nullable|string|in:in-progress,resolved,closed,on hiatus',
            'room_id' => 'required|exists:rooms,id',
            'part_type_id' => 'required|exists:building_parts,id',
            'mode_kegagalan' => 'nullable|string|max:255', // New field
            'severity' => 'nullable|string|max:10', // Changed to string
            'occurrence' => 'nullable|string|max:10', // Changed to string
            'detection' => 'nullable|string|max:10', // Changed to string
            'rekomendasi_tindakan' => 'nullable|string|max:255', // New field
        ]);

        $issue = Issue::find($id);
        if (!$issue) {
            return response()->json(['message' => 'Issue not found'], 404);
        }

        // Check if the request has the 'status' column before running the conditional logic
        if ($request->has('status')) {
            if ($issue->status == 'pending' && $validatedData['status'] != 'pending' && $user->isAdmin != 1) {
                return response()->json(['message' => 'You cannot change the status of a pending issue'], 403);
            }
        }

        // Update the issue with the validated data
        $issue->update($validatedData);

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
            // Delete the issue
            $issue->delete();
            return response()->json(['message' => 'Issue deleted successfully']);
        } else {
            return response()->json(['message' => 'Issue not found'], 404);
        }
    }
}
