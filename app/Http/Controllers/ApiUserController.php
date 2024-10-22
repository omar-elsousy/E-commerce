<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    public function register(Request $request){
        $validate=Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|email',
            'password'=>'required|string|confirmed'
        ]);
        if($validate->fails()){
            return response()->json([
                'errors'=>$validate->errors()
            ],300);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        return response()->json([
            'status'=>'success',
            'data'=>$user
        ],200);
    }
    
    public function login(Request $request){
        $validate=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string'
        ]);
        if($validate->fails()){
            return response()->json([
                'errors'=>$validate->errors()
            ],300);
        }
        $cred=['email'=>$request->email,'password'=>$request->password];
        if(Auth::attempt($cred)){
            Auth::user()->access_token=bin2hex(random_bytes(32));
            Auth::user()->save();
            return response()->json([
                'status'=>'success',
                'access_token'=>Auth::user()->access_token
            ],404);
        }else{
            return response()->json([
                'status'=>'failed',
                'msg'=>'wrong credintials'
            ],404);
        }
    }
    public function logout(Request $request){
        $access_token=$request->header('access_token');
        if($access_token!=null){
            $user=User::where('access_token',$access_token)->first();
            if($user){
                $user->update([
                    "access_token"=>null
                ]);
                return response()->json([
                    'msg'=>'You are logged out successfully'
                ],200);
            }else{
                return response()->json([
                    'msg'=>'access_token is not correct'
                ],404);
            }
        }else{
            return response()->json([
                'msg'=>'access_token is missing'
            ],404);
        }
    }
}
