<?php

namespace Leoo\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class LeooUserExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        /** @var array $configs */
        $configs = $this->importResource();

        foreach($configs as $name => $config) {
            if(!empty($container->getExtensionConfig($name))) {
                $container->prependExtensionConfig($name, $config);
            }
        }
    }

    /**
     * @return array
     */
    protected function importResource()
    {
        /** @var Yaml $parser */
        $parser = new Yaml();
        /** @var array $configs */
        $configs = $parser->parse(__DIR__.'/../Resources/config/config.yml');
        /** @var array $imports */
        $imports = $configs['imports'];

        unset($configs['imports']);

        foreach($imports as $import) {
            $configs = array_merge($configs, $parser->parse(__DIR__.'/../Resources/config/'.$import['resource']));
        }

        return $configs;
    }
}
