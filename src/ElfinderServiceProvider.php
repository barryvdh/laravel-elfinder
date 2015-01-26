<?php namespace Barryvdh\Elfinder;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class ElfinderServiceProvider extends RouteServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Barryvdh\Elfinder';

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        parent::register();

        $configPath = __DIR__ . '/../config/elfinder.php';
        $this->loadConfigFrom('elfinder', $configPath);
        $this->publishes([$configPath => config_path('elfinder.php')]);

        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom('elfinder', $viewPath);
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/elfinder'),
        ]);

        if (!defined('ELFINDER_IMG_PARENT_URL')) {
			define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/barryvdh/laravel-elfinder'));
		}
        
        $this->app['command.elfinder.publish'] = $this->app->share(function($app)
        {
			$publicPath = $app['path.public'];
            return new Console\PublishCommand($app['files'], $publicPath);
        });
        $this->commands('command.elfinder.publish');
	}

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $config = $this->app['config']->get('elfinder.route', []);
        $config['namespace'] = $this->namespace;

        $router = $this->app['Illuminate\Routing\Router'];
        $router->group($config, function($router)
        {
            $router->get('/', 'ElfinderController@showIndex');
            $router->any('connector', 'ElfinderController@showConnector');
            $router->get('popup', 'ElfinderController@showPopup');
            $router->get('tinymce', 'ElfinderController@showTinyMCE');
            $router->get('tinymce4', 'ElfinderController@showTinyMCE4');
            $router->get('ckeditor', 'ElfinderController@showCKeditor4');
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.elfinder.publish',);
	}

    /**
     * Register the package defaults.
     *
     * @param  string  $key
     * @param  string  $path
     * @return void
     */
    protected function loadConfigFrom($key, $path)
    {
        $defaults = $this->app['files']->getRequire($path);
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, config_merge($defaults, $config));
    }


}
