<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\ExtensionWithPlugins;

class CustomBundleContainerExtensionWithMissingConfigurationInterface extends ExtensionWithPlugins
{
    protected function getConfigurationClassName()
    {
        return '\\Matthias\\BundlePlugins\\Tests\\CustomBundleConfigurationMissingConfigurationInterface';
    }
}
