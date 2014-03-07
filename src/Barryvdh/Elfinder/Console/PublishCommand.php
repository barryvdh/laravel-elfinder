<?php
namespace Barryvdh\Elfinder\Console;
use Illuminate\Foundation\AssetPublisher;
use Illuminate\Console\Command;

/**
 * Publish the elFinder assets to the public directory
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */
class PublishCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'elfinder:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the elFinder assets';

    /**
     * The asset publisher instance.
     *
     * @var \Illuminate\Foundation\AssetPublisher
     */
    protected $assets;

    /**
     * Create a new Publish command
     *
     * @param \Illuminate\Foundation\AssetPublisher $assets
     */
    public function __construct(AssetPublisher $assets)
    {
        parent::__construct();

        $this->assets = $assets;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        $package = 'barryvdh/laravel-elfinder';
        if ( ! is_null($path = $this->getPath()))
        {
            $this->assets->publish($package, $path);
            $this->info('Assets published for package: '.$package);
        }
        else
        {
            $this->error('Could not find path for: '.$package);
        }

    }

    /**
     * Get the path of the assets folder. For now it's just vendor/barryvdh/laravel-elfinder/public,
     * but in the future could reference to a different composer package.
     */
    protected function getPath(){
        $path = with(new \ReflectionClass($this))->getFileName();
        return realpath(dirname($path).'/../../../../public');
    }


}
