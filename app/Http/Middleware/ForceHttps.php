<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Force HTTPS in production or when behind proxy
        if (config('app.env') === 'production' || $request->header('x-forwarded-proto') === 'https') {
            if (!$request->isSecure() && $request->header('x-forwarded-proto') !== 'https') {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        $response = $next($request);

        // Add security headers for HTTPS
        if ($request->isSecure() || $request->header('x-forwarded-proto') === 'https') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('Content-Security-Policy', "upgrade-insecure-requests");
        }

        return $response;
    }
}
