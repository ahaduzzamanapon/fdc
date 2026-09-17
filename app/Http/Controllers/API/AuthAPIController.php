<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthAPIController extends Controller
{
    /**
     * User / Default Guard Login API
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required_without:email|string',
            'email'    => 'required_without:username|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        $loginInput = $request->input('username') ?? $request->input('email');
        $password   = $request->input('password');

        // Find user by username or email
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username/email or password.'
            ], 401);
        }

        // Check if user is active if current_status exists
        if (isset($user->current_status) && strtolower($user->current_status) === 'inactive') {
            return response()->json([
                'success' => false,
                'message' => 'Account is inactive. Please contact system administrator.'
            ], 403);
        }

        // Generate Sanctum API token
        $token = $user->createToken('user-auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
                'user'       => [
                    'id'            => $user->id,
                    'username'      => $user->username,
                    'email'         => $user->email,
                    'name_bn'       => $user->name_bn,
                    'name_en'       => $user->name_en,
                    'mobile_no'     => $user->mobile_no,
                    'employee_type' => $user->employee_type,
                    'designation'   => $user->designation,
                    'department'    => $user->department,
                    'current_status'=> $user->current_status,
                ]
            ]
        ], 200);
    }


    /**
     * Logout authenticated user (Revoke current token)
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.'
        ], 200);
    }

    /**
     * Get authenticated user profile
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $request->user()
        ], 200);
    }
}
