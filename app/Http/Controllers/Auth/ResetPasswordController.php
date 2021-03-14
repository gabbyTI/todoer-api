<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{


    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        return ApiResponder::successResponse(trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return ApiResponder::failureResponse(trans($response), 422);
    }
}
