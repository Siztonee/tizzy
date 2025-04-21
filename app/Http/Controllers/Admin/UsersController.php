<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        
        if ($request->expectsJson()) {
            return response()->json($users);
        }

        return Inertia::render('Admin/Users/Index', compact('users'));
    }
}
