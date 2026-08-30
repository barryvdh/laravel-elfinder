<?php namespace Barryvdh\Elfinder\Tests;

use Barryvdh\Elfinder\AssetHelper;

class AssetHelperTest extends TestCase
{
    public function testItAppendsTheVersionToTheAssetUrl()
    {
        $url = AssetHelper::asset('packages/barryvdh/elfinder', 'js/elfinder.min.js');

        $this->assertSame(
            url('packages/barryvdh/elfinder/js/elfinder.min.js') . '?v=' . AssetHelper::version(),
            $url
        );
    }

    public function testItAcceptsAFilenameWithALeadingSlash()
    {
        $this->assertSame(
            AssetHelper::asset('packages/barryvdh/elfinder', 'css/theme.css'),
            AssetHelper::asset('packages/barryvdh/elfinder', '/css/theme.css')
        );
    }

    public function testTheVersionIsAShortStableHash()
    {
        $version = AssetHelper::version();

        $this->assertMatchesRegularExpression('/^[0-9a-f]{8}$/', $version);
        $this->assertSame($version, AssetHelper::version());
    }
}
