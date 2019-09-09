<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        TokenExpiredException::class,
        TokenInvalidException::class,
        JWTException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
      if( $request->is('api/*')){
        $code = method_exists($e,'getStatusCode')? $e->getStatusCode() : $e->getCode();
        if( $e instanceof TokenExpiredException){
          $message = 'Token is expired.';
        } else if( $e instanceof TokenInvalidException){
          $message = 'Token is invalid.';
        } else if( $e instanceof JWTException){
          $message = $e->getMessage()?:'Could not create token.';
        } else if( $e instanceof NotFoundHttpException){
          $message = $e->getMessage()?:'Not found.';
        } else if( $e instanceof ModelNotFoundException){
          $message = $e->getMessage()?:'Model not found.';
        } else if( $e instanceof Exception){
          $message = $e->getMessage()?:'Something broken :(';
        } else{
          $message = 'unknown error';
        }
        return response()->json([
          'code' => $code?:400,
          'errors' => array($message),
        ],$code?:400);
      }

      return parent::render($request, $e);

//      $response = parent::render($request, $e);
//
//      if ($request->is('api/*')) {
//        app('Barryvdh\Cors\Stack\CorsService')->addActualRequestHeaders($response, $request);
//      }
//
//      return $response;

    }
}
