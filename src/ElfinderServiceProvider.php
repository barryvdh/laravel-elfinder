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
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $config = require __DIR__ . '/../config/elfinder.php';
        $config = array_merge($config, $this->app['config']->get('elfinder', []));
        $this->app['config']->set('elfinder', $config);
        
        $this->package('barryvdh/laravel-elfinder', 'laravel-elfinder', __DIR__);

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
      // Register view files
      $appView = $this->app['path']."/views/packages/{$package}";
      if ($this->app['files']->isDirectory($appView))
      {
          $this->app['view']->addNamespace($namespace, $appView);
      }

      $this->app['view']->addNamespace($namespace, $path.'/views');
  }

}
