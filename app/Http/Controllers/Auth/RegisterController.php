<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Address;
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
    protected $redirectTo = '/';

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
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'postal_code' => ['nullable', 'string', 'digits:7'],
            'address' => ['nullable', 'string'],
            // 'building' => ['nullable', 'string'],
            'tel' => ['nullable', 'string', 'digits_between:10,11'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]
        );

        $user = User::where('email', $data['email'])->first();

        // nullエラー防止
        // isset($data['postal_code']) ? $data['postal_code'] : '';
        // isset($data['region']) ? $data['region'] : '';
        // isset($data['address']) ? $data['address'] : '';
        // isset($data['building']) ? $data['building'] : '';
        // isset($data['tel']) ? $data['tel'] : '';

        $address =Address::create(
            [
                'postal_code' => $data['postal_code'] ?? '',
                'region' => $data['region'] ?? '',
                'address' => $data['address'] ?? '',
                'building' => $data['building'] ?? '',
                'tel' => $data['tel'] ?? '',
                'user_id' => $user->id
            ]
        );

        return $user; //ログイン処理で$userが必要
    }
}
