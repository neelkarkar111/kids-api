<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubmitAnsController extends Controller
{
    // submit answer
    function submitAnswer(Request $request) {

         $validator = Validator::make($request->all(),[
            "user_id" => "required",
            "mission_id" => "required",
            "answer" => "required"
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ], 422);
        }
        
        // $request->validate([
        //     'user_id' => 'required',
        //     'mission_id' => 'required',
        //     'answer' => 'required'
        // ]);


        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }
        

        $mission =  Mission::find($request->mission_id);

        if(!$mission) {
            return response()->json([
                'status' => false,
                'message' => 'Mission not found'
            ], 404);
        }



        $correct = strtolower(trim($request->answer)) === strtolower(trim($mission->answer));

        $rewards = 0;

        if($correct) {
            $rewards = $mission->reward;

            $user->coins += $rewards;
            $user->progress += 1;
            $user->save();
        }

        return response()->json([
            "correct" => $correct,
            "reward" => $rewards,
            "coins" => $user->coins,
            "progress" => $user->progress
        ]);
    }
}