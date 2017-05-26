<?php

namespace Elcodi\Component\StateTransitionMachine\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\StateTransitionMachine\Entity\State;

/**
 * Class StateFactory.
 */
class StateFactory extends AbstractFactory
{
    /**
     * Creates an instance of State entity.
     *
     * @return State Empty entity
     */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
        $state = new $classNamespace();

        return $state;
    }
}
