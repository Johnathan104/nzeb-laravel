<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRequest;

use App\Models\User;
class AdminController extends Controller
{
    public function getAllUsers(AdminRequest $request)
    {
        $users = User::all(); // Fetch all users from the database
        return response()->json($users);
    }
    public function editUser(AdminRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id', // Ensure the user ID exists in the database
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id, // Ensure email is unique except for the current user
        ]);
    
        $user = User::find($validatedData['id']);    
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save(); 
    
        // Return a success response
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->email,
        ]);
    }
    public function checkadmin(AdminRequest $request)
    {
        $user = Auth::user();
  
            return response()->json(['message' => 'User is an admin'], 200);
    }
    public function deleteUser(AdminRequest $request)
    {
        $user = User::find($request->id);
        if($user){
            $user->delete();
            return response()->json(['message'=>'User deleted successfully']);
        }else{
            return response()-> json(['message'=>'User not found'], 404);
        }
    }
}
