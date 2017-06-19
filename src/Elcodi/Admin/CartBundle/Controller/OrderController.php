<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Admin\CartBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

/**
 * Class Controller for Order
 *
 * @Route(
 *      path = "/order",
 * )
 */
class OrderController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_order_list",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * Edit and Saves order
     *
     * @param OrderInterface $order Order
     *
     * @return array Data
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_order_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Template
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function editAction(OrderInterface $order)
    {
        $workflowStateLineStack = $order->getWorkflowStateLineStack();
        
        if ($workflowStateLineStack->hasStateLine()) {            
            $nextWorkflowTransitions = $this
                ->get('elcodi.order_workflow_states_machine_manager')
                ->getAvailableStates(
                    $order,
                    $workflowStateLineStack
                        ->getLastStateLine()
                        ->getState()
                        ->getName()
                );
        } else {
            $nextWorkflowTransitions = null;
        }
        
        $paymentStateLineStack = $order->getPaymentStateLineStack();
        
        if ($paymentStateLineStack->hasStateLine()) {            
            $nextPaymentTransitions = $this
                ->get('elcodi.order_payment_states_machine_manager')
                ->getAvailableStates(
                    $order,
                    $paymentStateLineStack
                        ->getLastStateLine()
                        ->getState()
                        ->getName()
                );
        } else {
            $nextPaymentTransitions = null;
        }
        

        $shippingStateLineStack = $order->getShippingStateLineStack();
        
        if ($shippingStateLineStack->hasStateLine()) {
            $nextShippingTransitions = $this
                ->get('elcodi.order_shipping_states_machine_manager')
                ->getAvailableStates(
                    $order,
                    $shippingStateLineStack
                        ->getLastStateLine()
                        ->getState()
                        ->getName()
                );
        } else {
            $nextShippingTransitions = null;
        }
        
        
        $productionStateLineStack = $order->getProductionStateLineStack();
        
        if ($productionStateLineStack->hasStateLine()) {
            $nextProductionTransitions = $this
                ->get('elcodi.order_production_states_machine_manager')
                ->getAvailableStates(
                    $order,
                    $productionStateLineStack
                        ->getLastStateLine()
                        ->getState()
                        ->getName()
                );
        } else {
            $nextProductionTransitions = null;
        }
        
        $allStatesAndEvents = array_merge(
            $workflowStateLineStack
                ->getStateLines()
                ->toArray(),
            $paymentStateLineStack
                ->getStateLines()
                ->toArray(),
            $shippingStateLineStack
                ->getStateLines()
                ->toArray(),
            $productionStateLineStack
                ->getStateLines()
                ->toArray(),
            $order
                ->getOrderEvents()
                ->toArray()
        );
        
        usort($allStatesAndEvents, function ($a, $b) {
            return $a->getCreatedAt() == $b->getCreatedAt()
                ? $a->getId() > $b->getId()
                : $a->getCreatedAt() > $b->getCreatedAt();
        });

        $addressFormatter = $this->get('elcodi.formatter.address');
        $deliveryAddress  = $order->getDeliveryAddress();
        $deliveryInfo     = $addressFormatter->toArray($deliveryAddress);

        $billingAddress   = $order->getBillingAddress();
        $billingInfo      = $addressFormatter->toArray($billingAddress);

        return [
            'order'                     => $order,
            'nextWorkflowTransitions'   => $nextWorkflowTransitions,
            'nextPaymentTransitions'    => $nextPaymentTransitions,
            'nextShippingTransitions'   => $nextShippingTransitions,
            'nextProductionTransitions' => $nextProductionTransitions,
            'allStatesAndEvents'                 => $allStatesAndEvents,
            'deliveryInfo'              => $deliveryInfo,
            'billingInfo'               => $billingInfo,
        ];
    }

    /**
     * Change payment state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/payment/{transition}",
     *      name = "admin_order_change_payment_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changePaymentStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $description = $transition;
        
        $stateLineStack = $this
            ->get('elcodi.order_payment_states_machine_manager')
            ->transition(
                $order,
                $order->getPaymentStateLineStack(),
                $transition,
                $description
            );

        $order->setPaymentStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Change shipping state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/shipping/{transition}",
     *      name = "admin_order_change_shipping_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changeShippingStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $description = $transition;
        
        $stateLineStack = $this
            ->get('elcodi.order_shipping_states_machine_manager')
            ->transition(
                $order,
                $order->getShippingStateLineStack(),
                $transition,
                $description
            );

        $order->setShippingStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Change production state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/production/{transition}",
     *      name = "admin_order_change_production_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changeProductionStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $description = $transition;
        
        $stateLineStack = $this
            ->get('elcodi.order_production_states_machine_manager')
            ->transition(
                $order,
                $order->getProductionStateLineStack(),
                $transition,
                $description
            );

        $order->setProductionStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Change workflow state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     * @param string         $transition Verb to apply
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/workflow/{transition}",
     *      name = "admin_order_change_workflow_state",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function changeWorkflowStateAction(
        Request $request,
        OrderInterface $order,
        $transition
    ) {
        $description = $transition;
        
        $stateLineStack = $this
            ->get('elcodi.order_workflow_states_machine_manager')
            ->transition(
                $order,
                $order->getWorkflowStateLineStack(),
                $transition,
                $description
            );

        $order->setWorkflowStateLineStack($stateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Change production state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/initialize-production-state-machine",
     *      name = "admin_order_initialize_production_state_machine",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function initializeProductionStateMachineAction(
        Request $request,
        OrderInterface $order
    ) {
        $productionStateLineStack = $this
            ->get('elcodi.order_production_states_machine_manager')
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Manual initializated'
            );

        $order->setProductionStateLineStack($productionStateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Change shipping state
     *
     * @param Request        $request    Request
     * @param OrderInterface $order      Order
     *
     * @return RedirectResponse Back to referrer
     *
     * @Route(
     *      path = "/{id}/initialize-shipping-state-machine",
     *      name = "admin_order_initialize_shipping_state_machine",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.order.class",
     *      name = "order",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function initializeShippingStateMachineAction(
        Request $request,
        OrderInterface $order
    ) {
        $shippingStateLineStack = $this
            ->get('elcodi.order_shipping_states_machine_manager')
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Manual initializated'
            );

        $order->setShippingStateLineStack($shippingStateLineStack);
        $this->flush($order);

        return $this->redirect($request->headers->get('referer'));
    }
}
