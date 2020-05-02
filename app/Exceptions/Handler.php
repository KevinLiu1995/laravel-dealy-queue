<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // 自定义验证失败的返回信息
        if ($exception instanceof ValidationException) {
            $errors = @$exception->validator->errors()->toArray();

            $msg = [];
            foreach (array_values($errors) as $array_value) {
                foreach ($array_value as $item) {
                    $msg[] = $item;
                }
            }
            $res = [
                'code' => 422,
                'msg' => $msg,
                'data' => []
            ];

            return response()->json($res)->setStatusCode(422);
        }
        return parent::render($request, $exception);
    }
}
