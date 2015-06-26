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
        $roots = $this->app->config->get($this->package . '::roots', []);

        if (empty($roots)) {

            $dirs = (array) $this->app->config->get($this->package . '::dir', []);
            foreach ($dirs as $dir) {
                $roots[] = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path($dir), // path to files (REQUIRED)
                    'URL' => url($dir), // URL to files (REQUIRED)
                    'accessControl' => $this->app->config->get($this->package . '::access') // filter callback (OPTIONAL)
                ];
            }

            $disks = (array) $this->app['config']->get($this->package . '::disks', []);
            if ($this->app->bound('flysystem')) {
                foreach ($disks as $key => $root) {
                    if (is_string($root)) {
                        $key = $root;
                        $root = [];
                    }
                    $driver = app('flysystem')->connection($key);
                    if ($driver instanceof \League\Flysystem\Filesystem) {
                        $defaults = [
                            'driver'     => 'Flysystem',
                            'filesystem' => $driver,
                            'alias'      => $key,
                        ];
                        $roots[] = array_merge($defaults, $root);
                    }
                }
            }
        }

        $opts = $this->app->config->get($this->package . '::options', array());
        $opts = array_merge(array('roots' => $roots), $opts);

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
