<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::with('pegawai')->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'These credentials do not match our records.'
            ], 404);
        }

        $token = $user->createToken('ApiToken', ['role' => $user->role])->plainTextToken;

        $expiresAt = now()->addHour('20');

        $accessToken = PersonalAccessToken::findToken($token);
        $accessToken->expires_at = $expiresAt;
        $accessToken->save();

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'expires_at' => $expiresAt
        ], 201);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'unique:users'],
            'password' => ['required'],
            'id_pegawai' => ['required']
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->id_pegawai = $request->id_pegawai;
        $user->save();

        $pegawai = Pegawai::find($user->id_pegawai);

        $email = $pegawai ? $pegawai->email : null;

        if ($email) {
            Mail::to($email)->send(new UserRegistered($user->username, $request->password, $email));
        } else {
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration Success'
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success Logout',
        ], 200);
    }

    public function validateToken(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Token is valid.',
            'user' => $request->user()
        ], 200);
    }

    public function getUser(Request $request)
    {
        $user = $request->user()->load('pegawai');
        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }
}
