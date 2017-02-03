<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use \Elcodi\Bundle\ProductBundle\Entity\Product;
use \Elcodi\Bundle\ProductBundle\Entity\ProductSize;
use \Elcodi\Bundle\ProductBundle\Entity\ProductColors;

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
     * @var Product
     */
    private $product;

    /**
     * @var ProductSize
     */
    private $size;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $colors;

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
     * Set product
     *
     * @param Product $product
     *
     * @return ProductSizes
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set size
     *
     * @param ProductSize $size
     *
     * @return ProductSizes
     */
    public function setSize(ProductSize $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return ProductSize
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add color
     *
     * @param ProductColors $color
     *
     * @return ProductSizes
     */
    public function addColor(ProductColors $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param ProductColors $color
     */
    public function removeColor(ProductColors $color)
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
	
	public function __toString() {
		return $this->getSize()->getName();
	}
}
