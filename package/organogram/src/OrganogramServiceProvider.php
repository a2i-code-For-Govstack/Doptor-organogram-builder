<?php

namespace a2i\organogram;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use a2i\organogram\Traits\UserInfoCollector;
use Illuminate\Support\Facades\Auth;
use a2i\organogram\Traits\ApiHeart;

class OrganogramServiceProvider extends ServiceProvider
{
    use UserInfoCollector;
    use ApiHeart;
    public function register() {}
    // can put multiple config file names
    protected $configFiles = [
        'menu_role_map.php'
    ];
    // List of controllers you want to publish 
    protected $controllers = [
        "Controller.stub" => "Controller.php",
    ];
    // List Models here to publish
    protected $models = [
        "User.stub" => "User.php",
    ];
    // List Traits files here to publish
    protected $traits = [
        "UserInfoCollector.stub" => "UserInfoCollector.php",
        "ApiHeart.stub" => "ApiHeart.php"
    ];
    // List Folder of Public Folder
    protected $publicAssets = [
        "assets",
        "css",
        "fonts",
        "images",
        "js"
    ];
    // List Routes files you want to publish
    protected $routes = [
        "web.stub" => "web.php"
    ];


    protected function fileIterator($filesList, $fromFolderPath, $targetFolderPath)
    {
        foreach ($filesList as $key => $value) {
            $this->publishes([
                __DIR__ . $fromFolderPath . $key => base_path($targetFolderPath . $value)
            ]);
        }
    }

    public function boot()
    {
        if (File::exists(__DIR__ . '/Helpers/genericHelper.php')) {
            require __DIR__ . '/Helpers/genericHelper.php';
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'organogrampkg');
        // To run migations put all the migrations file inside src/migrations folder
        // below line will run all your migrations when you run php artisan migrate command
        // $this->loadMigrationsFrom(__DIR__.'/migrations'); uncomment this line for doptor migrations

        foreach ($this->configFiles as $file) {
            $this->mergeConfigFrom(
                __DIR__ . '/config/' . $file,
                'organogrampkg'
            );
        }

        view()->composer('*', function ($view) {
            if (Auth::user()) {
                $userDetails = $this->getUserDetails();
                view()->share('userDetails', $userDetails);

                $userOffices = $this->getUserOfficesByDesignation();
                view()->share('userOffices', $userOffices);

                $userPermittedMenus = $this->getAssignedMenus();
                view()->share('userPermittedMenus', $userPermittedMenus);

                $userDesignation = $this->getUserOrganogramRoleName();
                view()->share('userDesignation', $userDesignation);

                $alert_notifications = $this->getAlertNotifications();
                view()->share('alert_notifications', $alert_notifications);
            }
        });

        // Publish all required files
        $this->fileIterator($this->controllers, '/stubs/Controllers/', 'app/Http/Controllers/');
        $this->fileIterator($this->models, '/stubs/Models/', 'app/Models/');
        $this->fileIterator($this->traits, '/stubs/Traits/', 'app/Traits/');
        $this->fileIterator($this->routes, '/stubs/routes/', 'routes/');
        // Publish assets
        foreach ($this->publicAssets as $key) {
            $this->publishes([
                __DIR__ . '/public/' . $key => public_path($key)
            ]);
        }
        $this->publishes([
            __DIR__ . '/Http/Controllers/Auth' => base_path('app/Http/Controllers/Auth'),
            __DIR__ . '/views/auth' => base_path('resources/views/auth'),
        ]);
    }
}
