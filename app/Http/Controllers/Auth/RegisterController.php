<?php

namespace Um\Http\Controllers\Auth;

use Um\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Um\Http\Requests\UserRegisterRequest;
use Um\Contracts\Repositories\UserRepositoryContract;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryContract $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    public function register(UserRegisterRequest $request)
    {
        $user = $this->user->createUser($request->all());
        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
