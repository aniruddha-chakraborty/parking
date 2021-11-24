<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Validator;
use Hash;

class AuthController extends Controller {
	
	public function login(Request $request) {
       $validator = Validator::make($request->all(), [ // <---
	        'email' => 'required',
	        'password' => 'required',
    	]);
	
    	if ($validator->validated()) {
    		if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
		    		return response()->json([
					    'success' => 'You are logged in!',
					    'info' => Auth::user(),
					    'token' => Crypt::encryptString(Auth::user()->id)
					]);
	    		} else {
			    	return response()->json([
					    'error' => 'Email or password was wrong',
					],207);
	    	}
    	} else {
    		return response()->json([
					    'error' => 'Please try again',
					],207);
    	}
	}

	public function register(Request $request) {
	       $validator = Validator::make($request->all(), [ // <---
		        'email' => 'required|email|unique:users',
		        'password' => 'required',
		        'name'	=> 'required',
		        'id_card' => 'required',
		        'vechicle' => 'required',
		        'type' => 'required' 
        	]);

    	if ($validator->fails()) {
    		return response()->json([
			    'error' => 'All the fileds are required',
			],207);
    	}

    	try {
	    	$user = new User;
	    	$user->name = $request->input('name');
	    	$user->email = $request->input('email');
	    	$user->password = Hash::make($request->input('password'));
	    	$user->id_card 	= $request->input('id_card');
	    	$user->type 	= $request->input('type');
	    	$user->vechicle = $request->input('vechicle');
	    	$user->save();
	    	return response()->json([
			    'message' => 'You are successfully registered',
			]);

    	} catch (Exception $e) {
    		return response()->json([
			    'message' => 'There was a problem while inserting the data',
			]);
    	}
	}
}