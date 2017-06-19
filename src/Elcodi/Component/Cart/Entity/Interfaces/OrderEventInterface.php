<?php

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;

/**
 * Interface OrderEventInterface.
 */
interface OrderEventInterface 
{
    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder();
    
    /**
     * Set Event name.
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName(string $name);

    /**
     * Get Event name.
     *
     * @return string Event name
     */
    public function getName();
    
    /**
     * Set Event description.
     *
     * @param string $description
     *
     * @return $this Self object
     */
    public function setDescription(string $description);

    /**
     * Get Event description.
     *
     * @return string Event description
     */
    public function getDescription();
}
