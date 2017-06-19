<?php

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Factory\OrderEventFactory;
use Elcodi\Component\Cart\Event\Abstracts\AbstractOrderEvent;

/**
 * Class OrderLoggingEventListener.
 *
 * Public methods:
 *
 * * logOrderEvent
 */
final class OrderLoggingEventListener
{
    /**
     * @var OrderEventFactory
     *
     * OrderEventFactory
     */
    private $orderEventFactory;

    /**
     * Built method.
     *
     * @param OrderEventFactory $orderEventFactory OrderEventFactory
     */
    public function __construct(
        OrderEventFactory $orderEventFactory
    ) {
        $this->orderEventFactory = $orderEventFactory;
    }

    /**
     * Log Order Event in Database 
     *
     * @param AbstractOrderEvent $event Event
     */
    public function logOrderEvent(AbstractOrderEvent $event)
    {        
        $order = $event->getOrder();
        
        $orderEvent = $this
            ->orderEventFactory
            ->create()
            ->setName($event->getName())
            ->setDescription($event->getDescription());
        
        $order->addOrderEvent($orderEvent);
        $orderEvent->setOrder($order);
    }
}
