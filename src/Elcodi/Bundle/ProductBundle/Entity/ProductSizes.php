<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

/**
 * ProductSizes
 */
class ProductSizes
{
    /**
     * @var integer
     */
    private $id;
	
	/**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $colors;
	
	/**
     * @var \Elcodi\Bundle\ProductBundle\Entity\Product
     */
    private $product;

    /**
     * @var \Elcodi\Bundle\ProductBundle\Entity\ProductSize
     */
    private $size;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->colors = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add color
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductColors $color
     *
     * @return ProductSizes
     */
    public function addColor(\Elcodi\Bundle\ProductBundle\Entity\ProductColors $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductColors $color
     */
    public function removeColor(\Elcodi\Bundle\ProductBundle\Entity\ProductColors $color)
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

    /**
     * Set product
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\Product $product
     *
     * @return ProductSizes
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
     * Set size
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductSize $size
     *
     * @return ProductSizes
     */
    public function setSize(\Elcodi\Bundle\ProductBundle\Entity\ProductSize $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return \Elcodi\Bundle\ProductBundle\Entity\ProductSize
     */
    public function getSize()
    {
        return $this->size;
    }
}
