<?php

namespace App\Repositories;

use App\Mail\resetPasswordMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthenticationRepository
{

    public function register(array $data): User
    {
        $user = User::create([
           'email' => $data['email'],
           'password' => Hash::make($data['password']),
        ]);
        $user->profile()->create([
            'first_name' => $data['first_name'] ,
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number']  ?? null,
            "address" => $data["address"] ?? null,
            "birthday" => $data["birthday"] ?? null,
            "gender" => $data["gender"] ?? null,
        ]);

        //additional logic to add

        return $user;
    }
    public function login(array $data): bool
    {
        // check https://laravel.com/docs/9.x/authentication#specifying-additional-conditions
        if (Auth::attempt($data)) {
            session()->regenerate();
            return true;
        }

        return false;
    }

    public function logout(Request $request)
    {
       auth()->user()->tokens()->delete();
       session()->invalidate();
       session()->regenerateToken();
       Auth::guard('web')->logout();

    }

   /* public function confirmPassword(array $data)
    {

    }

    public function sendVerificationEmail(array $data)
    {

    }*/

    public function resetPassword(array $data)
    {


        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password'],
                'token' => $data['token'],
                ]
            ,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status == Password::PASSWORD_RESET;
    }

    public function passwordResetLink(array $data): bool
    {

        $user = User::whereEmail($data['email'])->first();

        if (!$user->exists()){
            return false;
        }

        $token = Password::createToken($user);


        Mail::to($data['email'])->queue(new resetPasswordMail($token));

        return true;


    }



}
