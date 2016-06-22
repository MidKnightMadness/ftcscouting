<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Symfony\Component\HttpFoundation\Cookie;

class VerifyCsrfToken extends BaseVerifier {
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    // Heighten security of XSRF-TOKEN cookie by making it only accessible over HTTP, preventing the client from accessing it.
    protected function addCookieToResponse($request, $response) {
        $config = config('session');
        $cookie = new Cookie('XSRF-TOKEN', $request->session()->token(), time() + 60 * 120,
            $config['path'], $config['domain'], $config['secure'], true);
        $response->headers->setCookie($cookie);
        return $response;
    }
}
