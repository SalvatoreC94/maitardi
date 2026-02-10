<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Vuoto
    ];

    public function boot(): void
    {
        Gate::define('viewAdminPanel', function (User $user) {
            return (int) $user->is_admin === 1;
        });
    }
}
