<?php namespace Barryvdh\Elfinder;

use Composer\InstalledVersions;
use Illuminate\Support\Facades\URL;

class AssetHelper
{
    protected static ?string $version = null;

    /**
     * Get the URL for a published asset, with a version so browsers pick up
     * the new files after `php artisan elfinder:publish`.
     */
    public static function asset(string $dir, string $filename): string
    {
        return URL::asset($dir . '/' . ltrim($filename, '/')) . '?v=' . static::version();
    }

    /**
     * A short hash of the installed versions of the packages the assets are
     * published from, so it changes whenever either of them is updated.
     */
    public static function version(): string
    {
        return static::$version ??= substr(sha1(implode('|', [
            InstalledVersions::getVersion('studio-42/elfinder'),
            InstalledVersions::getReference('studio-42/elfinder'),
            InstalledVersions::getVersion('barryvdh/laravel-elfinder'),
            InstalledVersions::getReference('barryvdh/laravel-elfinder'),
        ])), 0, 8);
    }
}
