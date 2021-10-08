<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            User::paginate($request->get('per_page', 15))
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $newUser = User::create($validated);

        return response()->json(
            $newUser,
            201
        );
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response('', 204);
    }
}
