<?php

namespace Ipsum\Admin\app\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Registers admin HTTP error pages on the application exception handler.
 *
 * Previously extended a Core Handler and replaced the global handler singleton.
 * Core L13 uses renderable callbacks instead; Admin follows the same pattern.
 */
class Handler
{
    public static function register(ExceptionHandler $handler): void
    {
        $handler->renderable(function (HttpExceptionInterface $e, Request $request) {

            $prefix = config('ipsum.admin.route_prefix', 'administration').'/*';

            $status = $e->getStatusCode();

            // 419 => TokenMismatchException
            if ($status === 419 || $request->expectsJson() || ! $request->is($prefix)) {
                return null;
            }


            $view = "errors::{$status}"; 

            return view()->exists($view)
                ? response()->view($view, ['exception' => $e], $status, $e->getHeaders())
                : null;
        });
    }
}
