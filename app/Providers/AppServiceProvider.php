<?php

namespace App\Providers;

use App\Models\OrganUser;
use Illuminate\Support\Facades\Auth;
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
        //
        $loggedIn = Auth::user();
        if($loggedIn) {
            if ($loggedIn->hasRole('user')) {
                $senf = OrganUser::where('user_id', $loggedIn->id)->first();
                if ($senf)
                    $loggedIn['role'] = $senf->role;


            }

            view()->share('loggedIn', $loggedIn);
        }
    }
}
