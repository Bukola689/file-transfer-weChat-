<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */

    //      public function render($request, Throwable $exception)
    //      {
    //       if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
    //          return response()->json([
    //         'error' => 'Resource not found',
    //         'message' => 'The requested resource was not found'
    //         ], 404);
    //    }

    //      return parent::render($request, $exception);
    //     }
}
