<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['access_token' => 'required']);

        $query = User::query();

        if ($request->filled('type')) {
            $query->where('badge', $request->type);
        }

        if ($request->filled('points')) {
            $query->where('points', $request->points);
        }

        $users = $query->get()->map(function ($user) {
            $nextBadge = $this->getNextBadge($user->badge);
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'points' => $user->points,
                'badge' => $user->badge,
                'next_badge' => $nextBadge,
            ];
        });

        return response()->json($users);
    }

    protected function getNextBadge($currentBadge)
    {
        switch ($currentBadge) {
            case 'beginner-badge':
                return 'top-fan';
            case 'top-fan':
                return 'super-fan';
            default:
              return null;
        }
}

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return response()->json(['message' => 'User updated successfully']);
    }
}