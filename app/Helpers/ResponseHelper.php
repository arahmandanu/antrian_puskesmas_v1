<?php

namespace App\Helpers;

trait ResponseHelper
{
    public static function successResponse($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function errorResponse($message = 'Error', $status = 400, $errors = null)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}
