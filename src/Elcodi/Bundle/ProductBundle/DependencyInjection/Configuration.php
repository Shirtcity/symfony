<?php

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'product',
                            'Elcodi\Bundle\ProductBundle\Entity\Product',
                            '@ProductBundle/Resources/config/doctrine/Product.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'product_variant',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductVariant',
                            '@ProductBundle/Resources/config/doctrine/ProductVariant.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}
