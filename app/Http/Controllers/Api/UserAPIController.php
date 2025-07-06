<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserAPIController extends Controller
{
    public function registration(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth-token-for-'.$user->name)->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, (string) $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        $token = $user->createToken('auth-token-for-'.$user->name)->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = \Hash::make($request->password);
        $user->save();

        $token = $user->createToken('auth-token-for-'.$user->name)->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function tes() {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    public function favorites(Request $request)
    {
        $user = $request->user();

        $user->load('products');

        return response()->json([
            'favorites' => $user->products
        ]);
    }

    public function updateProfileImage(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $imagePath = $user->image_path;

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $destinationPath = public_path('assets/images');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            if ($user->image_path && file_exists(public_path($user->image_path))) {
                @unlink(public_path($user->image_path));
            }

            $image->move($destinationPath, $imageName);
            $imagePath = 'assets/images/' . $imageName;

        } elseif ($request->boolean('remove_image')) {
            if ($user->image_path && file_exists(public_path($user->image_path))) {
                @unlink(public_path($user->image_path));
            }
            $imagePath = null;
        }

        $user->image_path = $imagePath;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui',
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}