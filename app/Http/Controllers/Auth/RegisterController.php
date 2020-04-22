<?php

namespace Um\Http\Controllers\Auth;

use Um\Models\User;
use Um\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Um\Http\Requests\UserRegisterRequest;
use Illuminate\Auth\Events\Registered; 

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
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * It is used to rewrite a register function in RegistersUsers.
     *
     * @param  Features\Http\Requests\UserRegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $request->validated();

        //Registered is a class can be rewriten after successful registered. Event is similar as a listenr.
        event(new Registered($user = $this->create($request->all()))); 

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Um\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'first_name' => 1,
            'last_name' => 1,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => 0
        ]);
    }
}
