<?php

namespace Elcodi\Bundle\PrintableBundle\DependencyInjection;

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
                            'foilcolor',
                            'Elcodi\Bundle\PrintableBundle\Entity\FoilColor',
                            '@PrintableBundle/Resources/config/doctrine/FoilColor.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'design',
                            'Elcodi\Bundle\PrintableBundle\Entity\Design',
                            '@PrintableBundle/Resources/config/doctrine/Design.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'font',
                            'Elcodi\Bundle\PrintableBundle\Entity\Font',
                            '@PrintableBundle/Resources/config/doctrine/Font.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'text',
                            'Elcodi\Bundle\PrintableBundle\Entity\Text',
                            '@PrintableBundle/Resources/config/doctrine/Text.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'photo',
                            'Elcodi\Bundle\PrintableBundle\Entity\Photo',
                            '@PrintableBundle/Resources/config/doctrine/Photo.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->end();
    }
}
