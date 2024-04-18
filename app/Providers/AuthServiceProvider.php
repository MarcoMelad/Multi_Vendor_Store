<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        parent::register();
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });
    }

    public function boot()
    {
        $this->registerPolicies();

        foreach ($this->app->make('abilities') as $key => $value) {
            Gate::define($key, function ($user) use ($key) {
                return $user->hasAbility($key);
            });
        }
    }
}
