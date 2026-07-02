<?php

namespace App\Http\Controllers\Api;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use PasswordValidationRules, ProfileValidationRules;

    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ])->validate();

        /** @var User|null $user */
        $user = User::query()
            ->where('email', $credentials['email'])
            ->with(['organization'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 422);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            ...$this->profileRules(),
            'password' => ['required', 'string', 'min:6'],
            'organization_name' => [
                'required',
                'string',
                'max:255',
                'unique:organizations,name',
            ],
        ])->validate();

        /** @var User $user */
        $user = DB::transaction(function () use ($data) {
            $organization = Organization::create([
                'name' => $data['organization_name'],
            ]);

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'organization_id' => $organization->id,
                'role' => UserRole::Owner,
            ]);
        });
        $user->load(['organization']);
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}
