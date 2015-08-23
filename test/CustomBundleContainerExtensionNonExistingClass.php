<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\ExtensionWithPlugins;

class CustomBundleContainerExtensionNonExistingClass extends ExtensionWithPlugins
{
    protected function getConfigurationClassName()
    {
        return 'IDontExist';
    }
}
