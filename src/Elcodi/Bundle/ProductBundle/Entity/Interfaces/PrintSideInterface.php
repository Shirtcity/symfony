<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface PrintSideInterface.
 */
interface PrintSideInterface extends EnabledInterface
{
	/**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set position
     *
     * @param string $position
     *
     * @return PrintSide
     */
    public function setPosition($position);

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition();

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();
}
