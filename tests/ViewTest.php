<?php namespace Barryvdh\Elfinder\Tests;

use Barryvdh\Elfinder\AssetHelper;

class ViewTest extends TestCase
{
    /**
     * The routes that render a view, with their parameters.
     */
    protected array $routes = [
        'elfinder.index' => [],
        'elfinder.tinymce' => [],
        'elfinder.tinymce4' => [],
        'elfinder.tinymce5' => [],
        'elfinder.ckeditor' => [],
        'elfinder.popup' => ['input_id' => 'thumbnail'],
        'elfinder.filepicker' => ['input_id' => 'thumbnail'],
    ];

    public function testEveryViewRenders()
    {
        foreach ($this->routes as $route => $parameters) {
            $this->get(route($route, $parameters))
                ->assertOk()
                ->assertSee('id="elfinder"', false);
        }
    }

    public function testEveryViewLinksToTheVersionedAssets()
    {
        $version = AssetHelper::version();

        foreach ($this->routes as $route => $parameters) {
            $response = $this->get(route($route, $parameters));

            foreach (['css/elfinder.min.css', 'css/theme.css', 'js/elfinder.min.js'] as $file) {
                $response->assertSee("packages/barryvdh/elfinder/$file?v=$version", false);
            }
        }
    }

    public function testTheSoundPathIsNotVersioned()
    {
        // elFinder appends the filenames to this one, so a query string would break it.
        $this->get(route('elfinder.index'))
            ->assertSee("packages/barryvdh/elfinder/sounds'", false)
            ->assertDontSee('sounds?v=', false);
    }

    public function testEveryViewLoadsTheJqueryVersionUsedByElfinder()
    {
        foreach ($this->routes as $route => $parameters) {
            $this->get(route($route, $parameters))
                ->assertSee('//code.jquery.com/jquery-4.0.0.min.js', false)
                ->assertSee('//code.jquery.com/ui/1.14.2/jquery-ui.min.js', false);
        }
    }
}
