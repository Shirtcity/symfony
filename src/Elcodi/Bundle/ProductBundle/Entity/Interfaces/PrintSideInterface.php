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
     * Set type
     *
     * @param PrintSideTypeInterface $type
     *
     * @return PrintSide
     */
    public function setType(PrintSideTypeInterface $type = null);

    /**
     * Get type
     *
     * @return PrintSideType
     */
    public function getType();
}
