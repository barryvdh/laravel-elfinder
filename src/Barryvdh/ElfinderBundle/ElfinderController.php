<?php
namespace Barryvdh\ElfinderBundle;
class ElfinderController extends \BaseController {

    public function showIndex()
    {

        $dir = 'packages/barryvdh/elfinder-bundle';
        $locale = \Config::get('app.locale');
        if(!file_exists(public_path()."/$dir/js/i18n/elfinder.$locale.js")){
            $locale = false;
        }
        return \View::make('elfinder-bundle::elfinder')->with(compact('dir', 'locale'));
    }

    public function showTinyMCE()
    {

        $dir = 'packages/barryvdh/elfinder-bundle';
        $locale = \Config::get('app.locale');
        if(!file_exists(public_path()."/$dir/js/i18n/elfinder.$locale.js")){
            $locale = false;
        }
        return \View::make('elfinder-bundle::tinymce')->with(compact('dir', 'locale'));
    }
    public function showConnector(){

        $dir = \Config::get('elfinder-bundle::dir');

        $roots = \Config::get('elfinder-bundle::roots');

        if(!$roots){
            $roots = array(
                array(
                    'driver'        => 'LocalFileSystem',                       // driver for accessing file system (REQUIRED)
                    'path'          => public_path().DIRECTORY_SEPARATOR.$dir,  // path to files (REQUIRED)
                    'URL'           => asset($dir),                             // URL to files (REQUIRED)
                    'accessControl' => \Config::get('elfinder-bundle::access')  // filter callback (OPTIONAL)
                )
            );
        }

        // Documentation for connector options:
        // https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
        $opts = array(
            'roots' => $roots
        );

        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}
