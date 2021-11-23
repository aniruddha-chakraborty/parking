<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;


class OtherController extends Controller
{
    public function info(Request $request) {
    	 $value = Crypt::decryptString($request->token);
    	 Auth::login($value);
    	 return response()->json([
					    'id' => $value,
					]);
    }
}