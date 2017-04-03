<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface PrintSideTypeInterface.
 */
interface PrintSideTypeInterface
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
     * @return PrintSideType
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();
}
