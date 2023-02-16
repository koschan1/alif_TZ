<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request){
        if(Auth::attempt(["email" => $request->email, "password" => $request->password])){
            $user = Auth::user();
            $success["token"] = $user->createToken('MyApp')->plainTextToken;
            $success["name"] = $user->name;

            $responce = [
                "success" => true,
                "data" => $success,
                "message" => "User Login Successful"
            ];

            return response()->json($responce);
        }else{
            $responce = [
                "success" => false,
                "message" => "User Login False"
            ];

            return response()->json($responce);
        }
    }
}
