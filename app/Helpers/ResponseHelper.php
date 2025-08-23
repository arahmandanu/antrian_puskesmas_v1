<?php

namespace App\Helpers;

use App\Utils\Result;

trait ResponseHelper
{
    public static function customResponse($data = null, $message = 'Success')
    {
        if ($data->isFailure()) return self::errorResponse($message, 422, $data);

        return self::successResponse($data, $message);
    }

    public static function successResponse($data = null, $message = 'Success', $status = 200)
    {
        if (request()->method() != 'GET') {
            $status = 201;
        }

        return response()->json([
            'status'  => 'success',
            'message' => $data instanceof Result ? $data->getMessage() : $message,
            'data'    => $data instanceof Result ? $data->getData() : $data,
        ], $status);
    }

    public static function errorResponse($message = 'Error', $status = 400, $errors = null)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $errors instanceof Result ? $errors->getMessage() : $message,
            'errors'  => $errors instanceof Result ? $errors->getData() : $errors,
        ], $status);
    }

    public static function resultResponseData($data, $default = 200)
    {
        return response()->json([
            'status'  => $data['error'] ? 'error' : 'success',
            'message' => $data['message'],
            'errors'  => $data['error'],
            'data' => array_key_exists('data', $data) ? $data['data'] : null,
        ], $data['error'] ?  422 : $default);
    }
}
