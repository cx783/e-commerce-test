<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return response()->json(
            User::filter($this->request->only(['name', 'trashed']))
                ->paginate($this->request->get('per_page', 15))
        );
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store()
    {
        $validated = $this->validateRequest();

        $newUser = User::create($validated);

        return response()->json(
            $newUser,
            201
        );
    }

    public function update(User $user)
    {
        $validated = $this->validateRequest();

        $user->update($validated);

        return response()->json(
            $user->refresh()
        );
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response('', 204);
    }

    private function validateRequest()
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];

        if ($this->request->method() === 'POST') {
            $rules = array_merge($rules, $this->getPasswordRules());
        }

        return $this->request->validate($rules);
    }

    private function getPasswordRules(): array
    {
        return [
            'password' => ['required', 'string', 'confirmed']
        ];
    }
}
