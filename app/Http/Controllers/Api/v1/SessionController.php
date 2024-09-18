<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class SessionController extends Controller
{
    public function adminRegister(Request $request){
        $attrs = Validator::make($request->all(), [
            'name' => 'required|nullable',
            'email'=> 'required|email|unique:users,email,',
            'phone_no' => ['required', 'regex:/^\+251[97]\d{8}$/', 'unique:users,phone_no'],
            'password'=> ['required',Password::min(4), 'confirmed'],
        ]);

        if($attrs->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $attrs->errors()
            ], 401);
        }

        $user = User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        dispatch(function() use($user){
            event(new Registered($user));
        });


        $adminRoleApi = Role::where('name', 'school admin')->where('guard_name', 'api')->first();
        $adminRoleWeb = Role::where('name', 'school admin')->where( 'guard_name', 'web')->first();

        $user->assignRole($adminRoleApi);
        $user->assignRole($adminRoleWeb);

        return response()->json([
            'status' => true,
            'message' => 'School Admin Registerd Successfully. Email Verification link sent',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $user,
            ]
        ]);
    }

    public function teacherRegister(Request $request){
        $attrs = Validator::make($request->all(), [
            'name' => 'required|nullable',
            'email'=> 'required|email|unique:users,email,',
            'phone_no' => ['required', 'regex:/^\+251[97]\d{8}$/', 'unique:users,phone_no'],
            'password'=> ['required',Password::min(4), 'confirmed'],
        ]);

        if($attrs->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $attrs->errors()
            ], 401);
        }

        $user = User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        event(new Registered($user));

        $adminRoleApi = Role::where('name', 'teacher')->where('guard_name', 'api')->first();
        $adminRoleWeb = Role::where('name', 'school admin')->where( 'guard_name', 'web')->first();

        $user->assignRole($adminRoleApi);
        $user->assignRole($adminRoleWeb);

        return response()->json([
            'status' => true,
            'message' => 'Teacher Registerd Successfully. Email Verification link sent to the input email.',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $user,
            ]
        ]);
    }

    public function login(Request $request)
    {
        try {
            $attrs = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', Password::min(6)],
            ]);

            if ($attrs->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $attrs->errors()
                ], 401);
            }

            // Log request input
            Log::info('Phone No: ' . $request->phone_no);
            Log::info('Password: ' . $request->password);

            $user = User::where('email', $request->email)->first();

            // Log database password
            Log::info('Database Password: ' . $user->password);

            // dd($user);

            if (!$user || !Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                    'status' => false,
                    'message' => 'The credentials do not match',
                    'errors' => [
                        'message' => 'The credentials do not match'
                    ]
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'User login successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $attrs = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'phone_no' => ['required', 'regex:/^(09|07)[0-9]{8}$/'],
            'password'=> ['required', Password::min(4)],
        ]);

        if($attrs->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $attrs->errors()
            ], 401);
        }

        $request->user()->update([
            'name'=> $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        // EmailVerificationSend::dispatch($request->user());
        // event(new Registered($request->user()));

        return response()->json([
            'status' => true,
            'message' => 'User Credintials Updated Successfully',
            'token' => $request->user()->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $request->user(),
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );
    }

    public function destroy(Request $request){
        $request->user()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User Deleted Successfully'
        ]);
    }
}
