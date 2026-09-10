<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function hasOneThrough()
    {
        $user = User::with('class')->find(1);

        return response()->json([
            'user' => $user->name,
            'teacher' => $user->teacher->name ?? 'No Teacher',
            'class' => $user->class->name ?? 'No Class',
        ]);
    }// ============================================
    // Has Many Through: User → Classes (via Teacher)
    // ============================================
    public function hasManyThrough()
    {
        $user = User::with('classes')->find(1);

        return response()->json([
            'user' => $user->name,
            'total_classes' => $user->classes->count(),
            'classes' => $user->classes,
        ]);
    }

    // ============================================
    // All Users with Class Count
    // ============================================
    public function allUsersWithClassCount()
    {
        $users = User::withCount('classes')->get();

        return response()->json($users);
    }
}