<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\ExtensionWithPlugins;

class CustomBundleContainerExtension extends ExtensionWithPlugins
{
    protected function getConfigurationClassName()
    {
        return '\\Matthias\\BundlePlugins\\Tests\\CustomBundleConfiguration';
    }
}
