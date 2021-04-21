<?php

namespace App\Providers;

use App\Models\Gamer;
use App\Models\Superadmin;
use App\Models\TokenGamer;
use App\Models\TokenSuperadmin;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        $this->app['auth']->viaRequest('super', function ($request) {
            $auth = $this->getAuthenticationHeader($request);

            if (null === $auth) {
                return null;
            }

            $token = TokenSuperadmin::find($auth->value);

            if (null === $token) {
                return null;
            }

            $admin = Superadmin::where('username',$token->SuperadminUsername)->first();

            if (null === $admin) {
                return null;
            }

            return $admin;
        });

        $this->app['auth']->viaRequest('gamer', function ($request) {
            $auth = $this->getAuthenticationHeader($request);

            if (null === $auth) {
                return null;
            }

            $token = TokenGamer::find($auth->value);

            if (null === $token) {
                return null;
            }

            $gamer = Gamer::where('ID', $token->GamerID)->first();

            if (null === $gamer) {
                return null;
            }

            return $gamer;
        });
    }

    private function getAuthenticationHeader(\Laravel\Lumen\Http\Request $request)
    {
        $result = (object) [];

        if (!$request->headers->has('authorization')) {
            return null;
        }

        $result->type = explode(' ', $request->headers->get('authorization'))[0] ?? null;
        $result->value = explode(' ', $request->headers->get('authorization'))[1] ?? null;

        return $result;
    }
}
