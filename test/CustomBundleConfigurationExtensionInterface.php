<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface;

class CustomBundleConfigurationExtensionInterface implements ConfigurationExtensionInterface
{
    /**
     * Returns extension configuration
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @return ConfigurationInterface|null The configuration or null
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return null;
    }
}
