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
		$this->package('barryvdh/laravel-elfinder');
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
            //Make sure the asset publisher is registered.
            $app->register('Illuminate\Foundation\Providers\PublisherServiceProvider');
            return new Console\PublishCommand($app['asset.publisher']);
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

}
