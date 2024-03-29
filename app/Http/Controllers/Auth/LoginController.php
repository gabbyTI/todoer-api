<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        //attempt to issue a token to the user based on their login credentials
        $token = $this->guard()->attempt($this->credentials($request));

        // if credentials are wrong return false
        if (!$token) {
            return false;
        }

        //get auth user

        $user = $this->guard()->user();

        // if user email is not verified return false
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return false;
        }

        $this->guard()->setToken($token);

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        //get token
        $token = (string)$this->guard()->getToken();

        // get user
        $user = $this->guard()->user();

        //get expirydate
        $expiration = $this->guard()->getPayload()->get('exp');

        $payload = [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => new UserResource($user)
        ];

        return ApiResponder::successResponse("Login successful", $payload);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return ApiResponder::failureResponse("You need to verify your email account", 401);
        }

        return ApiResponder::failureResponse("Invalid login credentials", 422);
    }

    protected function logout(Request $request)
    {
        $user = $this->guard()->logout();

        return ApiResponder::successResponse("Logged out successfully", null, 204);
    }

    public function deleteAccount()
    {
        $user = auth()->user();
        $this->guard()->logout();
        $user->delete();
        return ApiResponder::successResponse("Account deleted");
    }
}
