<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface ProductSizeInterface.
 */
interface ProductSizeInterface
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
     * @return Size
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set orderAsc
     *
     * @param string $orderAsc
     *
     * @return Size
     */
    public function setOrderAsc($orderAsc);

    /**
     * Get orderAsc
     *
     * @return string
     */
    public function getOrderAsc();

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();
}
