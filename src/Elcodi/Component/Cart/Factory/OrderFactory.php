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

namespace Elcodi\Component\Cart\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class Order.
 */
class OrderFactory extends AbstractPurchasableFactory
{
    /**
     * @var MachineManager
     *
     * Machine Manager for Order Workflow
     */
    protected $workflowMachineManager;
    
    /**
     * @var MachineManager
     *
     * Machine Manager for Payment
     */
    protected $paymentMachineManager;

    /**
     * @var MachineManager
     *
     * Machine Manager for Shipping
     */
    protected $shippingMachineManager;
    
    /**
     * @var MachineManager
     *
     * Machine Manager for Production
     */
    protected $productionMachineManager;
    
    /**
     * Sets WorkflowMachineManager.
     *
     * @param MachineManager $workflowMachineManager WorkflowMachineManager
     *
     * @return $this Self object
     */
    public function setWorkflowMachineManager(MachineManager $workflowMachineManager)
    {
        $this->workflowMachineManager = $workflowMachineManager;

        return $this;
    }

    /**
     * Sets PaymentMachineManager.
     *
     * @param MachineManager $paymentMachineManager PaymentMachineManager
     *
     * @return $this Self object
     */
    public function setPaymentMachineManager(MachineManager $paymentMachineManager)
    {
        $this->paymentMachineManager = $paymentMachineManager;

        return $this;
    }

    /**
     * Sets ShippingMachineManager.
     *
     * @param MachineManager $shippingMachineManager ShippingMachineManager
     *
     * @return $this Self object
     */
    public function setShippingMachineManager(MachineManager $shippingMachineManager)
    {
        $this->shippingMachineManager = $shippingMachineManager;

        return $this;
    }
    
    /**
     * Sets ProductionMachineManager.
     *
     * @param MachineManager $productionMachineManager ProductionMachineManager
     *
     * @return $this Self object
     */
    public function setProductionMachineManager(MachineManager $productionMachineManager)
    {
        $this->productionMachineManager = $productionMachineManager;

        return $this;
    }

    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Order New Order instance
     */
    public function create()
    {
        /**
         * @var Order $order
         */
        $classNamespace = $this->getEntityNamespace();
        $order = new $classNamespace();
        $order
            ->setQuantity(0)
            ->setWidth(0)
            ->setHeight(0)
            ->setWidth(0)
            ->setWeight(0)
            ->setCreatedAt($this->now())
            ->setPurchasableAmount($this->createZeroAmountMoney())
            ->setAmount($this->createZeroAmountMoney())
            ->setCouponAmount($this->createZeroAmountMoney())
            ->setShippingAmount($this->createZeroAmountMoney())
            ->setOrderEvents(new ArrayCollection());

        $paymentStateLineStack = $this
            ->paymentMachineManager
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Order not paid'
            );

        $order->setPaymentStateLineStack($paymentStateLineStack);
        
        $workflowStateLineStack = $this
            ->workflowMachineManager
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Order created'
            );

        $order->setWorkflowStateLineStack($workflowStateLineStack);
        
        return $order;
    }
}