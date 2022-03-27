<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/v1/user.php'));

            Route::prefix('v1')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/v1/admin.php'));
        });

        Route::bind('authenticatedTransaction', function ($value) {
            return Transaction::where('id', $value)
                ->whereHas('balanceHistory.balance.user', function (Builder $query) {
                    $query->where('id', auth()->id());
                })->firstOrFail();
        });

        Route::bind('authenticatedInvoice', function ($value) {
            return Invoice::where('id', $value)
                ->whereHas('balanceHistory.balance.user', function (Builder $query) {
                    $query->where('id', auth()->id());
                })->firstOrFail();
        });

        Route::bind('trashedUser', function ($value) {
            return User::onlyTrashed()->where('id', $value)->firstOrFail();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
