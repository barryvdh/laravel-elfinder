<?php namespace Barryvdh\Elfinder\Tests;

use Illuminate\Filesystem\Filesystem;

class ConnectorTest extends TestCase
{
    protected string $root;

    protected function setUp(): void
    {
        $this->root = sys_get_temp_dir() . '/elfinder-connector-' . uniqid();
        mkdir($this->root);
        file_put_contents($this->root . '/example.txt', 'example');

        parent::setUp();
    }

    protected function tearDown(): void
    {
        (new Filesystem())->deleteDirectory($this->root);

        parent::tearDown();
    }

    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $app['config']->set('elfinder.roots', [
            [
                'driver' => 'LocalFileSystem',
                'path' => $this->root,
                'URL' => 'http://localhost/files',
            ],
        ]);
    }

    /**
     * elFinder reads the request straight from the superglobals, which a web
     * server fills in but the test kernel does not.
     */
    protected function connector(array $query)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = $query;

        try {
            return $this->getJson(route('elfinder.connector', $query));
        } finally {
            unset($_SERVER['REQUEST_METHOD']);
            $_GET = [];
        }
    }

    public function testItOpensTheRoot()
    {
        $response = $this->connector(['cmd' => 'open', 'target' => '', 'init' => 1]);

        $response->assertOk();
        $this->assertContains('example.txt', array_column($response->json('files'), 'name'));
    }

    public function testItReturnsAnErrorForAnUnknownCommand()
    {
        $this->connector(['cmd' => 'nope'])
            ->assertOk()
            ->assertJsonPath('error.0', 'errUnknownCmd');
    }
}
