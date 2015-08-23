<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;

class CustomBundle extends BundleWithPlugins
{
    private $containerExtensionClassName;

    protected function getAlias()
    {
        return 'bundle_with_customized_extension_and_configuration';
    }

    public function setContainerExtensionClassName($containerExtensionClassName)
    {
        $this->containerExtensionClassName = $containerExtensionClassName;
    }

    protected function getContainerExtensionClassName()
    {
        return $this->containerExtensionClassName;
    }
}
