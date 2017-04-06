<?php

namespace Elcodi\Bundle\CategoryBundle\DependencyInjection;

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
                            'category',
                            'Elcodi\Bundle\CategoryBundle\Entity\Category',
                            '@CategoryBundle/Resources/config/doctrine/Category.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'design_category',
                            'Elcodi\Bundle\CategoryBundle\Entity\DesignCategory',
                            '@CategoryBundle/Resources/config/doctrine/DesignCategory.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'product_category',
                            'Elcodi\Bundle\CategoryBundle\Entity\ProductCategory',
                            '@CategoryBundle/Resources/config/doctrine/ProductCategory.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'section_category',
                            'Elcodi\Bundle\CategoryBundle\Entity\SectionCategory',
                            '@CategoryBundle/Resources/config/doctrine/SectionCategory.orm.yml',
                            'default',
                            true
                        ))

                    ->end()
                ->end()
            ->end();
    }
}
