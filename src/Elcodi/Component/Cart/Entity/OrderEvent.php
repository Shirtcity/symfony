<?php

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderEventInterface;

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;

/**
 * OrderEvent.
 */
class OrderEvent implements OrderEventInterface
{
    use IdentifiableTrait, 
        DateTimeTrait;
    
    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;
    
    /**
     * @var Event name
     *
     * string
     */
    protected $name;
    
    /**
     * @var Event description
     *
     * string
     */
    protected $description;

    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * Set Event name.
     *
     * @param string $name
     *
     * @return $this Self object
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Event name.
     *
     * @return string Event name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set Event description.
     *
     * @param string $description
     *
     * @return $this Self object
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Event description.
     *
     * @return string Event description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
