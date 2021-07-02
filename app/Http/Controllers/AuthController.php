<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Unprocessable Entity'
            ],422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response([
                'message' => 'Unauthorized'
            ],401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|between:5,100',
            'username' => 'required|string|unique:users',
            'address' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'company_name' => 'string',
            'store_name' => 'string',
            'state' => 'string',
            'city' => 'string',
            'zipcode' => 'integer',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Bad Request'
            ],400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response([
                'data' => new UserResource($user) 
            ],201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response([
            'message' => 'User successfully signed out'
        ],200);
    }

    public function update(Request $request, $id)
    {
        $auth_user = Auth::user();
        $user = User::find($id);

        // check for user access
        if ($auth_user->id !== $user->id) {
            return response([
                'message' => 'Access denied'
            ]);
        } else {
            $user->update($request->all());
        };
        return response([
            'message' => 'Updated successfully',
            'data' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'username' => $user->username,
                'address' => $user->address,
                'role' => $user->role,
                'email' => $user->email,
                'company_name' => $user->company_name,
                'store_name' => $user->store_name,
                'state' => $user->state,
                'city' => $user->city,
                'zipcode' => $user->zipcode,
                'updated_at' => $user->created_at->toDateTimeString()
            ]
        ],201);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}