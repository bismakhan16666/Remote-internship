<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     * Har request ka URL log karta hai.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Har request ka URL, method aur time log karo
        Log::info('Request Log', [
            'url'    => $request->fullUrl(),
            'method' => $request->method(),
            'ip'     => $request->ip(),
            'time'   => now()->toDateTimeString(),
        ]);

        return $next($request);
    }
}