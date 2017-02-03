<?php


namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface DimensionableInterface.
 */
interface DimensionableInterface
{
    /**
     * Get Depth.
     *
     * @return int Depth
     */
    public function getDepth();

    /**
     * Get Height.
     *
     * @return int Height
     */
    public function getHeight();

    /**
     * Get Weight.
     *
     * @return int Weight
     */
    public function getWeight();

    /**
     * Get Width.
     *
     * @return int Width
     */
    public function getWidth();
}
