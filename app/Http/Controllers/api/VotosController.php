<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotosController extends Controller
{
    public function store(Request $request)
    {
      if( Auth::check()){
        $request['user_id']=Auth::id();
        return response()->json($request);
      }
      return response()->json('Usuario no conectado');
    }
}
