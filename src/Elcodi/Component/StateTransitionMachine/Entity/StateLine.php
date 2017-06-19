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

namespace Elcodi\Component\StateTransitionMachine\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateInterface;

/**
 * Class StateLine.
 */
class StateLine implements StateLineInterface
{
    use IdentifiableTrait, DateTimeTrait;
    
    /**
     * @var State
     */
    protected $state;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var StateLineStack
     *
     * StateLine Stack
     */
    protected $stateLineStack;
    
    /**
     * Sets State.
     *
     * @param State $state
     *
     * @return $this Self object
     */
    public function setState(StateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get State.
     *
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Get name of State.
     *
     * @return string name of State
     */
    public function getName()
    {
        return $this->state->getName();
    }

    /**
     * Sets Description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }
}
