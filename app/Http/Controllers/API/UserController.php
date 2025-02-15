<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->username == 'admin') {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved all users.',
            'data' => $users,
        ], 200);
    }
}
