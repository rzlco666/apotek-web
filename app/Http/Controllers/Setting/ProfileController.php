<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return view('setting.profile.index');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'new_password' => 'required|string',
            'old_password' => 'required|string'
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $new_password = str_replace(env('APP_KEY'), '', base64_decode($request->new_password));
        $old_password = str_replace(env('APP_KEY'), '', base64_decode($request->old_password));
        if (strlen($new_password) < 8) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => __('Password minimum 8 characters')
            ];
            return response()->json($result, $result['code']);
        }

        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,16}$/";
        if (!preg_match($password_regex, $new_password)) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => __('Password must contains one uppercase or lowercase and have one special character')
            ];
            return response()->json($result, $result['code']);
        }

        $user = User::where('id', Auth::user()->id)->first();

        if (!Hash::check($old_password, $user->password)) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'Old password is not match'
            ];
            return response()->json($result, $result['code']);
        }

        $user->password = Hash::make($new_password);

        if ($user->save()) {
            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Change password success'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'change password failed'
            ];
        }

        return response()->json($result, $result['code']);
    }


    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $validated = $request->validate([
            'name' => 'required|string|unique:users,name,'.$id.',id',
            'email' => 'required|email|max:200|unique:users,email,'.$id.',id',
        ]);

        if (!$validated) {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => $errors->all()
            ];

            return response()->json($result, $result['code']);
        }

        $user = User::where('id', $id)->first();

        if (!$user) {
            $result = [
                'code' => 404,
                'status' => false,
                'message' => 'Data not found'
            ];
            return response()->json($result, $result['code']);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            $result = [
                'code' => 200,
                'status' => true,
                'message' => 'Save data success'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => false,
                'message' => 'Save data failed'
            ];
        }

        return response()->json($result, $result['code']);
    }

}
