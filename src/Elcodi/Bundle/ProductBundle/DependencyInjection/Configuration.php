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
                            'product_color',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductColor',
                            '@ProductBundle/Resources/config/doctrine/ProductColor.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'product_colors',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductColors',
                            '@ProductBundle/Resources/config/doctrine/ProductColors.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'product_size',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductSize',
                            '@ProductBundle/Resources/config/doctrine/ProductSize.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'product_sizes',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductSizes',
                            '@ProductBundle/Resources/config/doctrine/ProductSizes.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'product_manufacturer',
                            'Elcodi\Bundle\ProductBundle\Entity\ProductManufacturer',
                            '@ProductBundle/Resources/config/doctrine/ProductManufacturer.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'print_side',
                            'Elcodi\Bundle\ProductBundle\Entity\PrintSide',
                            '@ProductBundle/Resources/config/doctrine/PrintSide.orm.yml',
                            'default',
                            true
                        ))
						->append($this->addMappingNode(
                            'print_side_type',
                            'Elcodi\Bundle\ProductBundle\Entity\PrintSideType',
                            '@ProductBundle/Resources/config/doctrine/PrintSideType.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}
