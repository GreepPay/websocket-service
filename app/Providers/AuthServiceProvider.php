<?php

namespace App\Providers;

use App\Models\Auth\User;
use App\Services\AuthService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Auth::extend("custom", function ($app, $name, array $config) {
            return new RequestGuard(
                function ($request) {
                    $token = $request->bearerToken();

                    if (!$token) {
                        return null;
                    }

                    $cacheKey = "auth_user_" . $token;
                    $response = cache()->remember(
                        $cacheKey,
                        now()->addMinutes(60),
                        function () use ($token) {
                            $authService = new AuthService();
                            return $authService->authUser();
                        }
                    );

                    if (!$response || empty($response["data"])) {
                        return null;
                    }

                    $user = User::query()
                        ->where("id", $response["data"]["id"])
                        // ->with("profile")
                        ->first();

                    return $user;
                },
                $app["request"],
                $app["auth"]->createUserProvider($config["provider"])
            );
        });
    }
}
