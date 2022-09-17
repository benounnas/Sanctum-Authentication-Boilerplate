<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AuthenticationConfirmPasswordRequest;
use App\Http\Requests\Authentication\AuthenticationLoginRequest;
use App\Http\Requests\Authentication\AuthenticationPasswordResetLinkRequest;
use App\Http\Requests\Authentication\AuthenticationRegisterRequest;
use App\Http\Requests\Authentication\AuthenticationResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\AuthenticationRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends BaseController
{
    protected AuthenticationRepository $authenticationRepository;
    public function __construct(AuthenticationRepository $authenticationRepository)
    {
        $this->authenticationRepository = $authenticationRepository;
    }

    public function register(AuthenticationRegisterRequest $request)
    {
        $user = $this->authenticationRepository->register($request->validated());
        return $this->successResponse('User created!', [
            "data"=> new UserResource($user),
          //  optional
          //  "token"=> $user->createToken('token-' . $user->id. '-'. $user->email)->plainTextToken
        ]);
    }

    public function login(AuthenticationLoginRequest $request)
    {

        if ($this->authenticationRepository->login($request->validated())){


            $user =  User::where('email', $request->email)->first();

            return $this->successResponse('Login successful', [
                "user"=>  new UserResource($user),
                "token"=> $user->createToken('token-' . $user->id. '-'. $user->email)->plainTextToken
            ]);
        }

        return $this->errorResponse(__('Invalid credentials'));

    }

    public function logout(Request $request)
    {
        $this->authenticationRepository->logout($request);
        return $this->successResponse('Logged out!');
    }

    //################## to do in future updates ##########
    /*public function verify_email(Request $request)
    {

    }*/
    //####################################################

    public function reset_password(AuthenticationResetPasswordRequest $request)
    {
        $status = $this->authenticationRepository->resetPassword($request->validated());

        if ($status != Password::PASSWORD_RESET) {

            return $this->errorResponse(__('Password could not be reset!'));

        }
        return $this->successResponse('Password was reset successfully', ['status' => __($status)]);

    }

    public function password_reset_link(AuthenticationPasswordResetLinkRequest $request)
    {

        $status = $this->authenticationRepository->passwordResetLink($request->validated());

        if (!$status) {
            return $this->errorResponse(__('The email is invalid.'));
        }

        return $this->successResponse('Password reset link has been sent!', []);

    }
}
