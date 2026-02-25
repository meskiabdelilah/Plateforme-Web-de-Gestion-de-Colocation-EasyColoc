<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() 
    {
        $stats = [
            'users_count' => User::count(),
        ];

        $users = User::all();
        
        return view('admin.dashboard', compact('stats', 'users'));
    }

    public function toggleBan(User $user) 
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? "L'utilisateur a été débloqué" : "L'utilisateur a été bloqué.";

        return back()->with('success', $status);
    }
}
