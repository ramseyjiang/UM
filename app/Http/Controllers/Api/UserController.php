<?php

namespace Um\Http\Controllers\Api;

use Illuminate\Http\Response;
use Um\Http\Controllers\Controller;
use Um\Http\Requests\UserLoginRequest;
use Um\Http\Requests\UserRegisterRequest;
use Um\Contracts\Repositories\UserRepositoryContract;
use Um\Contracts\Services\UserServiceContract;

class UserController extends Controller
{
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryContract $user)
    {
        // $this->middleware('auth:api', ['except' => ['login', 'list', 'delete', 'register']]);
        $this->user = $user;
    }
    /**
     * Rewrite login function in AuthenticatesUsers class for username or password login.
     *
     * @param UserLoginRequest $request
     * @param UserServiceContract $userService
     * @return void
     */
    public function login(UserLoginRequest $request, UserServiceContract $userService)
    {
        $userService->checkLogin($request->username, $request->password);
        $user = $request->user();

        if (!empty($user) && ($token = \JWTAuth::fromUser($user))) {
            return $this->respondWithToken($token);
        } else {
            return response()->json([
                'errors' => trans('auth.failed')
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
    /**
     * Register using api
     *
     * @param UserRegisterRequest $request
     * @return void
     */
    public function register(UserRegisterRequest $request)
    {
        $user = $this->user->createUser($request->all());
        $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    
    public function list()
    {
        return response()->json($this->user->getAllUsers());
    }

    public function store(UserRegisterRequest $request)
    {
        return response()->json($this->user->createUser($request->all()));
    }

    public function update(UserRegisterRequest $request, int $userId)
    {
        return response()->json($this->user->updateUser($request->all(), $userId));
    }

    public function destroy(int $userId)
    {
        $user = $this->user->getUser($userId);
        $user->delete();

        return response()->json($this->user->getAllUsers());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
