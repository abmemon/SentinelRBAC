<?php

namespace ABMemon\SentinelRBAC\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use ABMemon\SentinelRBAC\Permission;

class SentinelRbacServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/sentinelrbac.php');

        // Blade directives
        Blade::if('role', fn($role) => auth()->check() && auth()->user()->hasRole($role));
        Blade::if('permission', fn($permission) => auth()->check() && auth()->user()->hasPermission($permission));

        // Register middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('role', \ABMemon\SentinelRBAC\Middleware\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \ABMemon\SentinelRBAC\Middleware\PermissionMiddleware::class);

        // Gate before hook for super-admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        // Gate definitions for permissions
        Permission::all()->each(function ($permission) {
            Gate::define($permission->name, fn($user) => $user->hasPermission($permission->name));
        });

        // Publish config
        $this->publishes([
            __DIR__.'/../../config/sentinelrbac.php' => config_path('sentinelrbac.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/sentinelrbac.php', 'sentinelrbac');

        $this->commands([
            \ABMemon\SentinelRBAC\Console\Commands\MakeRoleCommand::class,
            \ABMemon\SentinelRBAC\Console\Commands\MakePermissionCommand::class,
            \ABMemon\SentinelRBAC\Console\Commands\RbacSetupCommand::class,
        ]);
    }
}
