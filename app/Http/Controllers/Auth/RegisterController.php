<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
             
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $input =$data;
        
        if (request()->hasFile('picture')) {
            $file = request()->file('picture');
            $folder = 'picture/user';
            $customName = 'user-'.time();
            $input['picture'] = uploadFile($file, $folder, $customName);
        }else{
            $input['picture'] = 'no-image.png';
        }

        if (request()->hasFile('signature')) {
            $file = request()->file('signature');
            $folder = 'images/signature';
            $customName = 'signature-'.time();
            $input['signature'] = uploadFile($file, $folder, $customName);
        }else{
            $input['signature'] = 'no-image.png';
        }


        if (array_key_exists('password', $input)) {
            $input['password'] = bcrypt($input['password']);
        }else{
            $input['password'] = bcrypt('12345678');
        }
        /** @var User $users */

        $users = User::create($input);
        return $users; 
    }
}
