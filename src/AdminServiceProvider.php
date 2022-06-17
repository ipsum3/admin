<?php

namespace Ipsum\Admin;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Ipsum\Admin\app\Exceptions\Handler;
use Ipsum\Admin\app\Models\Admin;
use Ipsum\Admin\app\Policies\AdminPolicy;
use Gate;

class AdminServiceProvider extends ServiceProvider
{

    protected $commands = [
        \Ipsum\Admin\app\Console\Commands\Install::class,
        \Ipsum\Admin\app\Console\Commands\CreateUser::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $policies = [
        Admin::class => AdminPolicy::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191); // Fix version de mysql

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViews();
        $this->loadTranslationsFrom(__DIR__.'/ressources/lang', 'IpsumAdmin');

        $this->publishFiles();

        $this->addCustomConfigurationValues();
        $this->addCustomAuthConfigurationValues();

        $this->registerMiddlewareGroup($this->app->router);

        $this->addPolicies();

    }


    public function loadViews()
    {
        $this->loadViewsFrom([
            resource_path('views/ipsum/admin'),
            __DIR__.'/ressources/views',
        ], 'IpsumAdmin');

        $this->app['view']->prependNamespace('aire', __DIR__.'/ressources/views/vendor/aire');

        $this->loadViewsFrom(__DIR__.'/ressources/views/errors', 'errors');
        // Overwrite ExceptionHandler for custom errors page
        if (request()->is(config('ipsum.admin.route_prefix').'*')) {
            $this->app->singleton(
                \Illuminate\Contracts\Debug\ExceptionHandler::class,
                Handler::class
            );


            Blade::anonymousComponentNamespace('IpsumAdmin::components', 'admin');
        }

    }


    public function addPolicies()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability, $models) {
            foreach ($models as $model) {
                if ($model[0] != config('ipsum.admin.user_model') or (is_object($model[0]) and get_class($model[0]) != config('ipsum.admin.user_model'))) {
                    return null;
                }
            }
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
        Gate::define('show-logs', function ($user) {
            return false;
        });
        Gate::define('show-settings', function ($user) {
            return true;
        });
        Gate::define('admin-acces', function ($user, $acces) {
            return $user->hasAcces($acces);
        });

    }

    public function addCustomConfigurationValues()
    {
        // add filesystems.disks for the log viewer
        config([
            'filesystems.disks.storage' => [
                'driver' => 'local',
                'root'   => storage_path(),
            ]
        ]);

    }

    public function addCustomAuthConfigurationValues()
    {
        // add the ipsum admin guard to the configuration
        app()->config['auth.guards'] = app()->config['auth.guards'] +
            [
                config('ipsum.admin.guard') => [
                    'driver'   => 'session',
                    'provider' => 'ipsumAdmin',
                ],
            ];
        // add the ipsum admin authentication provider to the configuration
        app()->config['auth.providers'] = app()->config['auth.providers'] +
            [
                'ipsumAdmin' => [
                    'driver'  => 'eloquent',
                    'model'   => config('ipsum.admin.user_model'),
                ],
            ];
        // add the ipsum admin password broker to the configuration
        app()->config['auth.passwords'] = app()->config['auth.passwords'] +
            [
                'ipsumAdmin' => [
                    'provider'  => 'ipsumAdmin',
                    'table'     => 'password_resets',
                    'expire'    => 60,
                ],
            ];

    }

    public function registerMiddlewareGroup(Router $router)
    {
        $router->aliasMiddleware('adminAuth', \Ipsum\Admin\app\Http\Middleware\Authenticate::class);
        $router->aliasMiddleware('adminGuest', \Ipsum\Admin\app\Http\Middleware\RedirectIfAuthenticated::class);

        foreach (config('ipsum.admin.middlewares') as $middleware_class) {
            $router->pushMiddlewareToGroup('admin', $middleware_class);
        }
    }

    public function publishFiles()
    {
        $this->publishes([
            __DIR__.'/ressources/views' => resource_path('views/ipsum/admin'),
        ], 'views');

        $this->publishes([
            __DIR__.'/config' => config_path(),
            base_path().'/vendor/ipsum3/admin-assets' => public_path('ipsum/admin'),
        ], 'install');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__.'/config/ipsum/admin.php', 'ipsum.admin'
        );

        if (! app()->configurationIsCached()) {
            $this->app['config']->set('aire', array_merge(
                app()['config']->get('aire', []), require __DIR__.'/config/ipsum/aire.php'
            ));
        }

        // register the artisan commands
        $this->commands($this->commands);
    }
}
