<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper as ResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Utils\Result;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                if (in_array(class_basename($e), ['NotFoundHttpException', 'ModelNotFoundException'])) {
                    return $this->throwCustomErrorJson('Resource not found', null);
                }
            }
        });
    }

    private function throwCustomErrorJson($message, $data = null)
    {
        return ResponseHelper::customResponse(Result::take(true, $data, $message));
    }
}
