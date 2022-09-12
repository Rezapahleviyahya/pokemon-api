<?php

namespace App\Http\Controllers;

use App\Models\ChatbotUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatbotUserController extends Controller
{
    /**
     * Store a user that has using the chatbot.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid request!',
                'data'    => $validator->getMessageBag()
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user_chatbot = ChatbotUser::create([
                'name' => $request->name
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'User data has been saved',
                'data'    => $user_chatbot
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            if (App::environment(['local', 'staging', 'testing'])) {
                return response()->json([
                    "error" => $e->getMessage(),
                    "data" => null
                ], 500);
            } else {
                Log::error($e->getMessage(), $request->all());
                return response()->json([
                    "error" => "Something wrong",
                    "data" => null
                ], 500);
            }
        }
    }
}
