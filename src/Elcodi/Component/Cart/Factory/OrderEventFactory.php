<?php

namespace Elcodi\Component\Cart\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Cart\Entity\OrderEvent;

/**
 * Class OrderEvent.
 */
class OrderEventFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return OrderEvent New OrderEvent instance
     */
    public function create()
    {
        /**
         * @var OrderEvent $orderEvent
         */
        $classNamespace = $this->getEntityNamespace();
        $orderEvent = new $classNamespace();
        $orderEvent->setCreatedAt($this->now());

        return $orderEvent;
    }
}
