<?php

namespace App\Helpers;

class ApiResponder
{
    public static function failureResponse($message, $code, $verification_errors = [])
    {
        return response()->json(
            [
                "success" => false,
                "message" => $message,
                "verification_errors" => $verification_errors
            ],
            $code
        );
    }

    public static function successResponse($message, $data)
    {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
                "data" => $data
            ],
        );
    }
}
