<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Response::macro('success', function ($data = [], $message = '', $status_code = 200) {
            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => $message
            ], $status_code);
        });

        Response::macro('errors', function ($data = [], $message = '', $status_code = 500) {
            return response()->json([
                'status' => false,
                "errors" => $data,
                'message' => $message,
            ], $status_code);
        });

        Response::macro('notFoundId',
        function ($message=null) {
            // Log::warning(Route::currentRouteAction()." ID not found");
            return response()->json([
                'status' => false,
                'message' => $message ?? 'ID not found',
            ], 404);
        });

        Response::macro('notFound',
        function ($message=null) {
            // Log::warning(Route::currentRouteAction()." failed, Not found");
            return response()->json([
                'status' => false,
                'message' => $message ?? 'Resource not found',
            ], 404);
        });
    }
}
