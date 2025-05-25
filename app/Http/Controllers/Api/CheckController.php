<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Check;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    /**
     * Get all checks.
     */
    public function index()
    {
        $checks = Check::all();
        return response()->json($checks);
    }
    public function self()
    {
        $user = request()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Token is missing or invalid'], 401);
        }
        $checks = Check::where('user_id', $user->id)->get();
        if ($checks->isEmpty()) {
            return response()->json(['message' => 'No checks found for this user'], 204);
        }
        return response()->json($checks);
    }

    /**
     * Store a new check.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,closed,in-progress',
            'date-start' => 'required|date',
            'date-end' => 'nullable|date|after_or_equal:date-start',
            'room_id' => 'required|exists:rooms,id',
            'issues_found' => 'nullable|array',
        ]);
        $user = $request->user();
        
        $check = Check::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'date-start' => $request->input('date-start'),
            'date-end' => $request->input('date-end'),
            'room_id' => $request->room_id,
            'user_id' => $user->id, // Assuming the user is authenticated

            'issues_found' => $request->issues_found ?? '[]',
        ]);

        return response()->json(['message' => 'Check created successfully', 'check' => $check], 201);
    }

    /**
     * Edit a specific check.
     */
    public function update(Request $request, $id)
    {
        $check = Check::findOrFail($id);
        $user = $request->user();
        if($user->id !== $check->user_id && !$user->isAdmin){
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,closed,in-progress',
            'date-start' => 'nullable|date',
            'date-end' => 'nullable|date|after_or_equal:date-start',
            'room_id' => 'nullable|exists:rooms,id',
            'issues_found' => 'nullable|array',
        ]);

        $check->update($request->only([
            'name',
            'description',
            'status',
            'date-start',
            'date-end',
            'room_id',
            'issues_found',
        ]));

        return response()->json(['message' => 'Check updated successfully', 'check' => $check]);
    }

    /**
     * Delete a specific check.
     */
    public function destroy($id)
    {
        $check = Check::findOrFail($id);
        $check->delete();

        return response()->json(['message' => 'Check deleted successfully']);
    }
}
