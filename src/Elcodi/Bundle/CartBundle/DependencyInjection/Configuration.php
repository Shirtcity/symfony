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

namespace Elcodi\Bundle\CartBundle\DependencyInjection;

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
                            'cart',
                            'Elcodi\Component\Cart\Entity\Cart',
                            '@ElcodiCartBundle/Resources/config/doctrine/Cart.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order',
                            'Elcodi\Component\Cart\Entity\Order',
                            '@ElcodiCartBundle/Resources/config/doctrine/Order.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'cart_line',
                            'Elcodi\Component\Cart\Entity\CartLine',
                            '@ElcodiCartBundle/Resources/config/doctrine/CartLine.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order_line',
                            'Elcodi\Component\Cart\Entity\OrderLine',
                            '@ElcodiCartBundle/Resources/config/doctrine/OrderLine.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'order_event',
                            'Elcodi\Component\Cart\Entity\OrderEvent',
                            '@ElcodiCartBundle/Resources/config/doctrine/OrderEvent.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('cart')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('save_in_session')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('session_field_name')
                            ->defaultValue('cart_id')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('workflow_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_workflow_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('preparing')
                        ->end()                        
                        ->variableNode('states')
                            ->defaultValue([
                                [
                                    'preparing',
                                    'cancel',
                                    'cancelled',
                                ],
                                [
                                    'cancelled',
                                    'prepare',
                                    'preparing',
                                ],
                                [
                                    'preparing',
                                    'stop',
                                    'paused',
                                ],
                                [
                                    'paused',
                                    'continue',
                                    'preparing',
                                ],
                            ])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('payment_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_payment_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('unpaid')
                        ->end()
                        ->variableNode('states')
                            ->defaultValue([
                                ['unpaid', 'pay', 'payment in process'],
                                ['payment in process', 'payment success', 'paid'],
                                ['payment in process', 'payment failed', 'unpaid'],
                                ['paid', 'refund', 'refunded'],
                                ['refunded', 'refund to unpaid', 'unpaid'],
                            ])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('production_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_production_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('ready for produce')
                        ->end()
                        ->scalarNode('workflow_state_line_stack_getter_name')
                            ->defaultValue('getWorkflowStateLineStack')
                        ->end()
                        ->scalarNode('workflow_block_states')
                            ->defaultValue([
                                'paused', 
                                'cancelled',
                            ])
                        ->end()
                        ->variableNode('states')
                            ->defaultValue([
                                ['ready for produce', 'start production', 'production started'],
                                ['production started', 'make order colection', 'order collection ready'],   
                                ['order collection ready', 'print working sheet', 'working sheet printed'],
                                ['working sheet printed', 'print delivery sheet', 'delivery sheet printed'],
                                ['delivery sheet printed', 'print post sheet', 'post sheet printed'],
                                ['post sheet printed', 'print pdf invoice', 'pdf invoice printed'],
                                ['pdf invoice printed', 'produce order', 'order producing in progress'],                             
                                ['order producing in progress', 'finish production', 'produced'],
                            ])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('shipping_states_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('identifier')
                            ->defaultValue('order_shipping_states_machine')
                        ->end()
                        ->scalarNode('point_of_entry')
                            ->defaultValue('ready for delivery')
                        ->end()
                        ->scalarNode('workflow_state_line_stack_getter_name')
                            ->defaultValue('getWorkflowStateLineStack')
                        ->end()
                        ->scalarNode('workflow_block_states')
                            ->defaultValue([
                                'paused', 
                                'cancelled',
                            ])
                        ->end()
                        ->variableNode('states')
                            ->defaultValue([
                                ['ready for delivery', 'pack', 'packed'],                                
                                ['packed', 'send', 'in delivery'],
                                ['in delivery', 'delivered', 'delivered'],                                
                                ['in delivery', 'return', 'returned'],
                                ['delivered', 'return', 'returned'],
                                ['returned', 'delivery failed', 'delivery failed'],
                            ])
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}