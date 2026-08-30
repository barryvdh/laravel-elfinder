<?php namespace Barryvdh\Elfinder\Tests;

use Barryvdh\Elfinder\ElfinderServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [ElfinderServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        // Needed by the 'web' middleware group, which encrypts the cookies.
        $app['config']->set('app.key', 'base64:' . base64_encode(random_bytes(32)));

        // The default 'auth' middleware would redirect to a login route that does not exist here.
        $app['config']->set('elfinder.route.middleware', ['web']);
    }
}
