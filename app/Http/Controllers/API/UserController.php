<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = request()->user();
        
        if ($user->tokenCan('user:index')) 
        {
            $users = User::orderBy('created_at', 'DESC')->paginate(10);
            return response()->json(['status' => 'success', 'data' => $users]);
        }
        
        return response()->json(['status' => 'failed', 'data' => 'Unauthorized']);
    }
}
