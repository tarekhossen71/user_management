<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country'   => ['required', 'string'],
            'state'   => ['required', 'string'],
            'postal_code'   => ['required', 'integer'],
            'phone'   => ['required', 'integer'],
            'birthday'   => ['required', 'date','max:255'],
            'status'   => ['required', 'string','max:255'],
            'avater'    => ['required', 'image','mimes:jpg,jpeg,png']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // File Upload
        $avater      = $data['avater'];
        $ext         = $avater->getClientOriginalExtension();
        $unique_name = uniqid().'.'.$ext;
        $avater->move('profile/', $unique_name);
        
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'status'   => $data['status'],
            'avater'   => $unique_name,
        ]);

        Address::create([
            'user_id'     => $user->id,
            'country_id'  => $data['country'],
            'state'       => $data['state'],
            'postal_code' => $data['postal_code'],
            'phone'       => $data['phone'],
            'birthday'    => $data['birthday'],
        ]);

        return $user;
    }
}
