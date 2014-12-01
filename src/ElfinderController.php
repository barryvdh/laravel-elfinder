<?php namespace Barryvdh\Elfinder;

use Barryvdh\Elfinder\Support\BaseController;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ElfinderController extends BaseController
{
    protected $package = 'laravel-elfinder';

    public function showIndex()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return $this->app['view']->make($this->package . '::elfinder')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return $this->app['view']->make($this->package . '::tinymce')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        $csrf = $this->app->config->get($this->package . '::csrf');
        
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return $this->app['view']->make($this->package . '::tinymce4')->with(compact('dir', 'locale','csrf'));
    }

    public function showCKeditor4()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }
        return $this->app['view']->make($this->package . '::ckeditor4')->with(compact('dir', 'locale'));
    }

    public function showConnector()
    {
        $dir = $this->app->config->get($this->package . '::dir');
        $roots = $this->app->config->get($this->package . '::roots');

        if (!$roots)
        {
            $roots = array(
                array(
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => $this->app['path.public'] . DIRECTORY_SEPARATOR . $dir, // path to files (REQUIRED)
                    'URL' => $this->app['url']->asset($dir), // URL to files (REQUIRED)
                    'accessControl' => $this->app->config->get($this->package . '::access') // filter callback (OPTIONAL)
                )
            );
        }

        $opts = $this->app->config->get($this->package . '::options', array());
        $opts = array_merge(array(
                'roots' => $roots
            ), $opts);

        // run elFinder
        $connector = new Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

    public function showPopup($input_id)
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        if ( ! file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js"))
        {
            $locale = false;
        }

        return $this->app['view']->make($this->package . '::standalonepopup')->with(compact('dir', 'locale', 'input_id'));
    }
}
