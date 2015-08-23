<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ConfigurationExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Extend your bundle from this class. It allows users to register plugins for this bundle by providing them as
 * constructor arguments.
 *
 * The bundle itself can have no container extension or configuration anymore. Instead, you can introduce something
 * like a `CorePlugin`, which is registered as a `BundlePlugin` for this bundle. Return an instance of it from your
 * bundle's `alwaysRegisteredPlugins()` method.
 */
abstract class BundleWithPlugins extends Bundle
{
    /**
     * @var BundlePlugin[]
     */
    private $registeredPlugins = array();

    /**
     * @return string
     */
    abstract protected function getAlias();

    /**
     * Constructed with an array of plugins to load
     *
     * @param array $plugins
     */
    final public function __construct(array $plugins = array())
    {
        foreach ($this->alwaysRegisteredPlugins() as $plugin) {
            $this->registerPlugin($plugin);
        }

        foreach ($plugins as $plugin) {
            $this->registerPlugin($plugin);
        }
    }

    /**
     * @inheritdoc
     */
    final public function build(ContainerBuilder $container)
    {
        foreach ($this->registeredPlugins as $plugin) {
            $plugin->build($container);
        }
    }

    /**
     * @inheritdoc
     */
    final public function boot()
    {
        foreach ($this->registeredPlugins as $plugin) {
            $plugin->boot($this->container);
        }
    }

    /**
     * Provide any number of `BundlePlugin`s that should always be registered.
     *
     * @return BundlePlugin[]
     */
    protected function alwaysRegisteredPlugins()
    {
        return array();
    }

    /**
     * Can be overridden to set class name for custom Extension
     *
     * @return string
     */
    protected function getContainerExtensionClassName()
    {
        return '\\Matthias\\BundlePlugins\\ExtensionWithPlugins';
    }

    /**
     * @inheritdoc
     */
    final public function getContainerExtension()
    {
        $className = $this->getContainerExtensionClassName();

        if (!class_exists($className)) {
            throw new \Exception("Class '" . $className . "' does not exist");
        }

        $containerExtension = new $className($this->getAlias(), $this->registeredPlugins);

        if (($containerExtension instanceof ExtensionInterface) === false) {
            throw new \Exception("Class '" . $className . "' must implement ExtensionInterface");
        }

        if (($containerExtension instanceof ConfigurationExtensionInterface) === false) {
            throw new \Exception("Class '" . $className . "' must implement ConfigurationExtensionInterface");
        }

        return $containerExtension;
    }

    /**
     * Register a plugin for this bundle.
     *
     * @param BundlePlugin $plugin
     */
    private function registerPlugin(BundlePlugin $plugin)
    {
        $this->registeredPlugins[] = $plugin;
    }
}
