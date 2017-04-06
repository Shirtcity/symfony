<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface PrintMethodInterface.
 */
interface PrintMethodInterface extends EnabledInterface
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
     * @return PrintMethod
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set hexcode
     *
     * @param string $hexcode
     *
     * @return PrintMethod
     */
    public function setHexcode($hexcode);

    /**
     * Get hexcode
     *
     * @return string
     */
    public function getHexcode();
}
