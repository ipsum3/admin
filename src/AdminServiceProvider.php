<?php

namespace Ipsum\Admin;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Ipsum\Admin\app\Exceptions\Handler;
use Ipsum\Admin\app\Models\Admin;
use Ipsum\Admin\app\Policies\AdminPolicy;
use Gate;

class AdminServiceProvider extends ServiceProvider
{

    protected array $commands = [
        \Ipsum\Admin\app\Console\Commands\Install::class,
        \Ipsum\Admin\app\Console\Commands\CreateUser::class,
    ];

    protected $policies = [
        Admin::class => AdminPolicy::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerAdminExceptionHandling();

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViews();
        $this->loadTranslationsFrom(__DIR__.'/ressources/lang', 'IpsumAdmin');

        $this->publishFiles();

        $this->addCustomConfigurationValues();
        $this->addCustomAuthConfigurationValues();

        $this->registerMiddlewareGroup($this->app->router);

        $this->addPolicies();

        if (request()->is(config('ipsum.admin.route_prefix').'*')) {
            Paginator::useBootstrapFour();
        }


    }


    public function loadViews(): void
    {
        $this->loadViewsFrom( __DIR__.'/ressources/views', 'IpsumAdmin');

        $this->app['view']->prependNamespace('aire', __DIR__.'/ressources/views/vendor/aire');

        $this->loadViewsFrom(__DIR__.'/ressources/views/errors', 'errors');
        Blade::anonymousComponentNamespace('IpsumAdmin::components', 'admin-test'); // TODO voir si on peux garder anonymous
        Blade::componentNamespace('Ipsum\\Admin\\app\\View\\Components', 'admin');
    }


    protected function registerAdminExceptionHandling(): void
    {
        Handler::register($this->app->make(\Illuminate\Contracts\Debug\ExceptionHandler::class));
    }

    public function addPolicies(): void
    {
        $this->registerPolicies();

        Gate::before(static function ($user, $ability, $models) {
            foreach ($models as $model) {
                if (empty($model[0]) or $model[0] != config('ipsum.admin.user_model') or (is_object($model[0]) and get_class($model[0]) != config('ipsum.admin.user_model'))) {
                    return null;
                }
            }
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
        Gate::define('show-logs', static function ($user) {
            return false;
        });
        Gate::define('show-settings', static function ($user) {
            return true;
        });
        Gate::define('admin-acces', static function ($user, $acces) {
            return $user->hasAcces($acces);
        });
        Gate::define('admin-role', static function ($user, $role) {
            return $user->hasRole($role);
        });
        Gate::define('super-admin-acces', static function ($user) {
            return false;
        });
    }

    public function addCustomConfigurationValues(): void
    {
        // add filesystems.disks for the log viewer
        config([
            'filesystems.disks.storage' => [
                'driver' => 'local',
                'root'   => storage_path(),
            ]
        ]);

    }

    public function addCustomAuthConfigurationValues(): void
    {
        // add the ipsum admin guard to the configuration
        app()->config['auth.guards'] += [
            config('ipsum.admin.guard') => [
                'driver' => 'session',
                'provider' => 'ipsumAdmin',
            ],
        ];
        // add the ipsum admin authentication provider to the configuration
        app()->config['auth.providers'] += [
            'ipsumAdmin' => [
                'driver' => 'eloquent',
                'model' => config('ipsum.admin.user_model'),
            ],
        ];
        // add the ipsum admin password broker to the configuration
        app()->config['auth.passwords'] += [
            'ipsumAdmin' => [
                'provider' => 'ipsumAdmin',
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ];

    }

    public function registerMiddlewareGroup(Router $router): void
    {
        $router->aliasMiddleware('adminAuth', \Ipsum\Admin\app\Http\Middleware\Authenticate::class);
        $router->aliasMiddleware('adminGuest', \Ipsum\Admin\app\Http\Middleware\RedirectIfAuthenticated::class);

        foreach (config('ipsum.admin.middlewares') as $middleware_class) {
            $router->pushMiddlewareToGroup('admin', $middleware_class);
        }
    }

    public function publishFiles(): void
    {
        $this->publishes([
            __DIR__.'/ressources/views' => resource_path('views/vendor/IpsumAdmin'),
        ], 'views');

        $this->publishes([
            __DIR__.'/config' => config_path(),
            base_path().'/vendor/ipsum3/admin-assets' => public_path('ipsum/admin'),
        ], 'install');

        if (config('ipsum.admin.assets_path')) {
            $this->publishes([
                config('ipsum.admin.assets_path') => public_path('ipsum/admin/dist'),
            ], ['laravel-assets', 'ipsum-admin-assets']);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
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
