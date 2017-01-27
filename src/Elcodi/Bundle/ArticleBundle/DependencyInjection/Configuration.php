<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ArticleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration.
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
                            'purchasable',
                            'Elcodi\Component\Article\Entity\Purchasable',
                            '@ElcodiArticleBundle/Resources/config/doctrine/Purchasable.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'article',
                            'Elcodi\Component\Article\Entity\Article',
                            '@ElcodiArticleBundle/Resources/config/doctrine/Article.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'article_variant',
                            'Elcodi\Component\Article\Entity\Variant',
                            '@ElcodiArticleBundle/Resources/config/doctrine/Variant.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'category',
                            'Elcodi\Component\Article\Entity\Category',
                            '@ElcodiArticleBundle/Resources/config/doctrine/Category.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'manufacturer',
                            'Elcodi\Component\Article\Entity\Manufacturer',
                            '@ElcodiArticleBundle/Resources/config/doctrine/Manufacturer.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('articles')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_stock')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('related_articles_adapter')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('adapter')
                                    ->defaultValue('elcodi.related_articles_provider_adapter.same_category')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('categories')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('load_only_categories_with_articles')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('cache_key')
                            ->defaultValue('categories')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('related_purchasables_provider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('adapter')
                            ->defaultValue('elcodi.related_purchasables_provider.same_category')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
