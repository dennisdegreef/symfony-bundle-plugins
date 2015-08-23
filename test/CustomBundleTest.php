<?php

namespace Matthias\BundlePlugins\Tests;

class CustomBundleTest extends IsolatedKernelTestCase
{
    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Class 'CustomNonExistingContainer' does not exist
     */
    public function it_should_break_on_non_existing_custom_extension()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('CustomNonExistingContainer');

        $this->createKernel(array(), array($customBundle));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Class '\Matthias\BundlePlugins\Tests\CustomBundleExtensionInterface' must implement ConfigurationExtensionInterface
     */
    public function it_should_break_when_not_implementing_extension_interface()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('\\Matthias\BundlePlugins\\Tests\\CustomBundleExtensionInterface');

        $this->createKernel(array(), array($customBundle));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Class '\Matthias\BundlePlugins\Tests\CustomBundleConfigurationExtensionInterface' must implement ExtensionInterface
     */
    public function it_should_break_when_not_implementing_configuration_extension_interface()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('\\Matthias\BundlePlugins\\Tests\\CustomBundleConfigurationExtensionInterface');

        $this->createKernel(array(), array($customBundle));
    }

    /**
     * @test
     */
    public function it_should_be_able_to_use_custom_configuration()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('\\Matthias\BundlePlugins\\Tests\\CustomBundleContainerExtension');

        $this->createKernel(array(), array($customBundle));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Class 'IDontExist' does not exist
     */
    public function it_should_have_an_existing_class_for_custom_configuration()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('\\Matthias\BundlePlugins\\Tests\\CustomBundleContainerExtensionNonExistingClass');

        $this->createKernel(array(), array($customBundle));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Class '\Matthias\BundlePlugins\Tests\CustomBundleConfigurationMissingConfigurationInterface' does not implement ConfigurationInterface
     */
    public function it_should_fail_when_custom_configuration_does_not_implement_configuration_interface()
    {
        $customBundle = new CustomBundle();
        $customBundle->setContainerExtensionClassName('\\Matthias\BundlePlugins\\Tests\\CustomBundleContainerExtensionWithMissingConfigurationInterface');

        $this->createKernel(array(), array($customBundle));
    }

}
