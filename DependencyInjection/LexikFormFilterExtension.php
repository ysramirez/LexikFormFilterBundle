<?php

namespace Lexik\Bundle\FormFilterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class LexikFormFilterExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('form.xml');
        $loader->load('listeners.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['force_case_insensitivity'])) {
            $filterPrepareDef = $container->getDefinition('lexik_form_filter.filter_prepare');
            $filterPrepareDef->addMethodCall(
                'setForceCaseInsensitivity',
                array($config['force_case_insensitivity'])
            );
        }

        $container->setParameter('lexik_form_filter.where_method', $config['where_method']);
    }
}
