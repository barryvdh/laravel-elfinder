<?php namespace Barryvdh\Elfinder;

use Illuminate\Support\ServiceProvider;

class ElfinderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('barryvdh/laravel-elfinder', 'laravel-elfinder', __DIR__);

        if (!defined('ELFINDER_IMG_PARENT_URL')) {
			define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('packages/barryvdh/laravel-elfinder'));
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['command.elfinder.publish'] = $this->app->share(function($app)
        {
			$publicPath = $app['path.public'];
            return new Console\PublishCommand($app['files'], $publicPath);
        });
        $this->commands('command.elfinder.publish');
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
   * Register the package's component namespaces.
   *
   * @param  string  $package
   * @param  string  $namespace
   * @param  string  $path
   * @return void
   */
  public function package($package, $namespace = null, $path = null)
  {
      // Is it possible to register the config?
      if (method_exists($this->app['config'], 'package')) {
          $this->app['config']->package($package, $path.'/config', $namespace);
      } else {
          // Load the config for now..
          $config = $this->app['files']->getRequire($path .'/config/config.php');
          foreach($config as $key => $value){
              $this->app['config']->set($namespace.'::'.$key, $value);
          }
      }
      // Register view files
      $appView = $this->app['path']."/views/packages/{$package}";
      if ($this->app['files']->isDirectory($appView))
      {
          $this->app['view']->addNamespace($namespace, $appView);
      }

      $this->app['view']->addNamespace($namespace, $path.'/views');
  }

}
