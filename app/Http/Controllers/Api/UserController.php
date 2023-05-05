<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'id_user' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $cek = User::where('id_user', $loginData['id_user'])->where('password', $loginData['password'])->first();

        if (!$cek) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong ID or Password'
            ], 401);
        } else {
            $data = [
                'id_user' => $request->id_user,
                'password' => $request->password,
                'role' => $cek->role,
                'foto_profil' => $cek->foto_profil,
            ];
            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => $data,
            ], 200);
        }
    }

    public function changePassword(Request $request)
    {
        $changePasswordData = $request->all();

        $validate = Validator::make($changePasswordData, [
            'id_user' => 'required',
            'password' => 'required',
            'new_password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        if ($changePasswordData['password'] == $changePasswordData['new_password']) {
            return response()->json([
                'success' => false,
                'message' => 'New Password cannot be the same as current password',
            ], 401);
        }

        $cek = User::where('id_user', $changePasswordData['id_user'])->where('password', $changePasswordData['password'])->first();

        if (!$cek) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong ID or Password'
            ], 401);
        } else {
            $user = User::where('id_user', $changePasswordData['id_user'])->where('password', $changePasswordData['password'])->first();
            $user->password = $changePasswordData['new_password'];
            // $user->save();
            User::where('id_user', $changePasswordData['id_user'])->update(['password' => $changePasswordData['new_password']]);

            return response()->json([
                'success' => true,
                'message' => 'Change Password Success',
                'data' => $changePasswordData,
            ], 200);
        }
    }

    public function updateFoto(Request $request)
    {
        $cek = User::where('id_user', $request->id_user)->first();

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$cek) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $imageName = $request->file('foto_profil')->getClientOriginalName();
        $request->foto_profil->move(public_path('images'), $imageName);

        User::where('id_user', $request->id_user)->update(['foto_profil' => $imageName]);

        return response()->json([
            'success' => true,
            'message' => 'Foto Profil Updated',
            'data' => $imageName,
        ], 200);
    }

    public function getImage($id)
    {
        $filename = User::where('id_user', $id)->first();
        if (!$filename) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $filename = $filename['foto_profil'];
        $path = public_path('images/' . $filename);
        if (!file_exists($path)) {
            return response()->json([
                'message' => 'File not found'
            ], 404);
        }
        $file = file_get_contents($path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $response = response($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function getUser($id)
    {
        $data = User::where('id_user', $id)->first();
        if (!$data) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $data = [
            'id_user' => $id,
            'password' => $data->password,
            'role' => $data->role,
            'foto_profil' => $data->foto_profil,
        ];
        return response()->json([
            'success' => true,
            'message' => 'User Found',
            'data' => $data,
        ], 200);
    }
}
