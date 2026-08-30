<?php namespace Barryvdh\Elfinder\Tests;

use Barryvdh\Elfinder\Console\PublishCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class PublishCommandTest extends TestCase
{
    protected string $publicPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publicPath = sys_get_temp_dir() . '/elfinder-publish-' . uniqid();
    }

    protected function tearDown(): void
    {
        (new Filesystem())->deleteDirectory($this->publicPath);

        parent::tearDown();
    }

    public function testItPublishesTheFilesTheViewsLinkTo()
    {
        $this->publish();

        $dir = $this->publicPath . '/packages/barryvdh/elfinder';

        // From elFinder itself.
        $this->assertFileExists($dir . '/js/elfinder.min.js');
        $this->assertFileExists($dir . '/css/elfinder.min.css');
        $this->assertFileExists($dir . '/css/theme.css');
        $this->assertDirectoryExists($dir . '/img');
        $this->assertDirectoryExists($dir . '/sounds');

        // From this package.
        $this->assertFileExists($dir . '/js/standalonepopup.min.js');
        $this->assertFileExists($dir . '/js/tiny_mce_popup.js');
    }

    public function testItReplacesPreviouslyPublishedAssets()
    {
        $this->publish();

        $stale = $this->publicPath . '/packages/barryvdh/elfinder/js/i18n/elfinder.old.js';
        file_put_contents($stale, 'stale');

        $this->publish();

        $this->assertFileDoesNotExist($stale);
    }

    protected function publish(): void
    {
        $command = new PublishCommand(new Filesystem(), $this->publicPath);
        $command->setLaravel($this->app);

        $this->assertSame(0, $command->run(new ArrayInput([]), new BufferedOutput()));
    }
}
