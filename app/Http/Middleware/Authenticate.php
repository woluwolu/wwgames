<?php

namespace App\Http\Middleware;

use App\Responses\ApiResponse;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->auth->shouldUse($guard);

        if ($guard == 'gamer') {
            $user = $this->auth->user();

            if (!$request->headers->has('authorization')) {
                return ApiResponse::send(401, null, 'Authorization Header Absent!');
            }

            if ($this->auth->guard($guard)->guest()) {
                return ApiResponse::send(401, null, 'Token Invalid!');
            }

            if (!$request->headers->has('devicetype')) {
                return ApiResponse::send(401, null, 'Devicetype Header Absent!');
            }

            if (null === $user) {
                return ApiResponse::send(401);
            }
        }

        if ($guard == 'super') {
            $user = $this->auth->user();

            if (null === $user) {
                return ApiResponse::send(401);
            }
        }

        return $next($request);
    }
}
