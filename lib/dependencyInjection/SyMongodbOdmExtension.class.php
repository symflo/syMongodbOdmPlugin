<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;

/**
 * @author Florent Mondoloni
 */
class SyMongodbOdmExtension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );

        $loader->load('services.xml');
    }

    public function getXsdValidationBasePath()
    {
        return false;
    }

    public function getNamespace()
    {
        return false;
    }

    public function getAlias()
    {
        return 'sy_mongodb_odm';
    }
}