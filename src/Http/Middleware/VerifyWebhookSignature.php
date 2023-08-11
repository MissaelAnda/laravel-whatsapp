<?php

namespace MissaelAnda\Whatsapp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            empty($secret = Config::get('whatsapp.secret')) ||
            empty($signature = $request->header('X-Hub-Signature-256')) ||
            !Str::startsWith($signature, 'sha256=') ||
            !hash_equals(hash_hmac('sha256', $request->getContent(), $secret), Str::after($signature, 'sha256='))
        ) {
            throw new AccessDeniedHttpException;
        }

        return $next($request);
    }
}
