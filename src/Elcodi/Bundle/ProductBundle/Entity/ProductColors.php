<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use \Elcodi\Bundle\ProductBundle\Entity\Product;
use \Elcodi\Bundle\ProductBundle\Entity\ProductSizes;
use \Elcodi\Bundle\ProductBundle\Entity\ProductColor;

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
     * @var Product
     */
    private $product;

    /**
     * @var ProductColor
     */
    private $color;

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
     * @return ProductColors
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
     * Set color
     *
     * @param ProductColor $color
     *
     * @return ProductColors
     */
    public function setColor(ProductColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return ProductColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add size
     *
     * @param ProductSizes $size
     *
     * @return ProductColors
     */
    public function addSize(ProductSizes $size)
    {
		$size->addColor($this);
        $this->sizes[] = $size;

        return $this;
    }

    /**
     * Remove size
     *
     * @param ProductSizes $size
     */
    public function removeSize(ProductSizes $size)
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
	
	public function __toString() {
		return $this->getColor()->getCode();
	}
}
