<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //show all users

    function showAll(){

        $allUsers = User::all();

        return response()->json([
            "status" => true,
            "message" => "All Users Data",
            "users" => $allUsers
        ], 201);
    }


    // show single user
    function singleUser($id)
    {
        $user = User::select('id', 'name',  'age', 'coins', 'progress')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'user' => $user
        ], 201);
    }

    function updateCoins(Request $request,$id){

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        
        $user->update([
            'coins' => $request->coins ?? $user->coins,
            'progress' => $request->progress ?? $user->progress,
         ]);

         return response()->json([
            "status" => true,
            "message" => "User Updated Successfully",
            "user" => $user->only(['id','name', 'coins',]),
         ], 201);
    }
}
