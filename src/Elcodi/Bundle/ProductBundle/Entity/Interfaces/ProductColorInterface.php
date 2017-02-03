<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface ProductColorInterface.
 */
interface ProductColorInterface
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
     * @return Color
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Color
     */
    public function setCode($code);

    /**
     * Get code
     *
     * @return string
     */
    public function getCode();

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();
}
