<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

/**
 * ProductColors
 */
class ProductColors
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sizes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sizes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add size
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductSizes $size
     *
     * @return ProductColors
     */
    public function addSize(\Elcodi\Bundle\ProductBundle\Entity\ProductSizes $size)
    {
        $this->sizes[] = $size;

        return $this;
    }

    /**
     * Remove size
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductSizes $size
     */
    public function removeSize(\Elcodi\Bundle\ProductBundle\Entity\ProductSizes $size)
    {
        $this->sizes->removeElement($size);
    }

    /**
     * Get sizes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSizes()
    {
        return $this->sizes;
    }
    /**
     * @var \Elcodi\Bundle\ProductBundle\Entity\Product
     */
    private $product;

    /**
     * @var \Elcodi\Bundle\ProductBundle\Entity\ProductColor
     */
    private $color;


    /**
     * Set product
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\Product $product
     *
     * @return ProductColors
     */
    public function setProduct(\Elcodi\Bundle\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Elcodi\Bundle\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set color
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductColor $color
     *
     * @return ProductColors
     */
    public function setColor(\Elcodi\Bundle\ProductBundle\Entity\ProductColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \Elcodi\Bundle\ProductBundle\Entity\ProductColor
     */
    public function getColor()
    {
        return $this->color;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $colors;


    /**
     * Add color
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductSizes $color
     *
     * @return ProductColors
     */
    public function addColor(\Elcodi\Bundle\ProductBundle\Entity\ProductSizes $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductSizes $color
     */
    public function removeColor(\Elcodi\Bundle\ProductBundle\Entity\ProductSizes $color)
    {
        $this->colors->removeElement($color);
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColors()
    {
        return $this->colors;
    }
	
}
