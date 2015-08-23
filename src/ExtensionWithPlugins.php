<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ExtensionWithPlugins extends Extension
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var BundlePlugin[]
     */
    private $registeredPlugins;

    /**
     * @param string $alias The alias for this extension (i.e. the configuration key)
     * @param array $registeredPlugins The plugins that were registered
     */
    public function __construct($alias, array $registeredPlugins)
    {
        $this->registeredPlugins = $registeredPlugins;
        $this->alias = $alias;
    }

    /**
     * @inheritdoc
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($config, $container);

        $processedConfiguration = $this->processConfiguration($configuration, $config);

        $this->loadInternal($processedConfiguration, $container);

        foreach ($this->registeredPlugins as $plugin) {
            $this->loadPlugin($container, $plugin, $processedConfiguration);
        }
    }

    /**
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        // Do nothing by default
    }

    /**
     * @return string
     */
    protected function getConfigurationClassName()
    {
        return '\\Matthias\\BundlePlugins\\ConfigurationWithPlugins';
    }

    /**
     * @inheritdoc
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $className = $this->getConfigurationClassName();

        if (class_exists($className) === false) {
            throw new \Exception("Class '" . $className . "' does not exist");
        }

        $configuration = new $className($this->getAlias(), $this->registeredPlugins);

        if (($configuration instanceof ConfigurationInterface) === false) {
            throw new \Exception("Class '" . $className . "' does not implement ConfigurationInterface");
        }

        return $configuration;
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param ContainerBuilder $container
     * @param BundlePlugin $plugin
     * @param array $processedConfiguration The fully processed configuration values for this bundle
     */
    private function loadPlugin(ContainerBuilder $container, BundlePlugin $plugin, array $processedConfiguration)
    {
        $container->addClassResource(new \ReflectionClass(get_class($plugin)));

        $pluginConfiguration = $this->pluginConfiguration($plugin, $processedConfiguration);

        $plugin->load($pluginConfiguration, $container);
    }

    /**
     * Get just the part of the configuration values that applies to the given plugin.
     *
     * @param BundlePlugin $plugin
     * @param array $processedConfiguration The fully processed configuration values for this bundle
     * @return array
     */
    private function pluginConfiguration(BundlePlugin $plugin, array $processedConfiguration)
    {
        if (!isset($processedConfiguration[$plugin->name()])) {
            return array();
        }

        return $processedConfiguration[$plugin->name()];
    }
}
