<?php

namespace Um\Http\Controllers\Api;

use Illuminate\Http\Response;
use Um\Http\Controllers\Controller;
use Um\Http\Requests\UserLoginRequest;
use Um\Http\Requests\UserRegisterRequest;
use Um\Contracts\Repositories\UserRepositoryContract;
use Um\Contracts\Services\UserServiceContract;
use Auth;

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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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
        var_dump($request->username, $request->password, $userService->checkLogin($request->username, $request->password));
        // $userService->checkLogin($request->username, $request->password);

        if ($user = $request->user()) {
            return response()->json([
                'status' => 'ok',
                'access_token' => $user->createToken('Personal Access Token')->accessToken,
                'token_type' => 'bearer',
                'isAdmin' => $user->is_admin
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
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

        try{
            return response()->json([
                'status' => 'ok',
                'access_token' => $user->createToken('Personal Access Token')->accessToken,
                'token_type' => 'bearer',
                'isAdmin' => $user->is_admin
            ], Response::HTTP_CREATED);
        }catch (\Throwable $t) {
            return response()->json([
                'status' => 'fail',
                'errors' => trans('auth.failed')
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(auth()->guard('api')->check()) {
            auth()->user()->token()->revoke();
            auth()->guard('api')->user()->token()->delete();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {
        return response()->json(auth()->user());
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
        // $user = Auth::user();
        // $this->authorize('match', $user);
        return response()->json($this->user->updateUser($request->all(), $userId));
    }

    public function destroy(int $userId)
    {
        $user = Auth::user();
        var_dump($user);
        // $this->authorize('match', $user);
        // $targetUser = $this->user->getUser($userId);
        // $targetUser->delete();

        return response()->json($this->targetUser->getAllUsers());
    }
}
