<?php

namespace Elcodi\Component\StateTransitionMachine\Entity\Interfaces;

/**
 * Interface StateInterface.
 */
interface StateInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return State
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return State
     */
    public function setIcon($icon);

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon();
}
