<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {

    public function render($request, Throwable $e) {
        if ($e instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return parent::render($request, $e);
    }

}
