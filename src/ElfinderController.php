<?php namespace Barryvdh\Elfinder;

use Barryvdh\Elfinder\Support\BaseController;

class ElfinderController extends BaseController
{
    protected $package = 'laravel-elfinder';

    public function showIndex()
    {
        return $this->app['view']
            ->make($this->package . '::elfinder')
            ->with($this->getViewVars());
    }

    public function showTinyMCE()
    {
        return $this->app['view']
            ->make($this->package . '::tinymce')
            ->with($this->getViewVars());
    }

    public function showTinyMCE4()
    {

        return $this->app['view']
            ->make($this->package . '::tinymce4')
            ->with($this->getViewVars());
    }

    public function showCKeditor4()
    {
        return $this->app['view']
            ->make($this->package . '::ckeditor4')
            ->with($this->getViewVars());
    }

    public function showPopup($input_id)
    {
        return $this->app['view']
            ->make($this->package . '::standalonepopup')
            ->with($this->getViewVars())
            ->with(compact('input_id'));
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

    protected function getViewVars()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = $this->app->config->get('app.locale');
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js")) {
            $locale = false;
        }
        $csrf = true;
        return compact('dir', 'locale', 'csrf');
    }
}
