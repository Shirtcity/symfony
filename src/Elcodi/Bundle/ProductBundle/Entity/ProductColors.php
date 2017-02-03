<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizesInterface;

/**
 * ProductColors
 */
class ProductColors implements ProductColorsInterface
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
     * @param ProductInterface $product
     *
     * @return ProductColors
     */
    public function setProduct(ProductInterface $product)
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
     * @param ProductColorInterface $color
     *
     * @return ProductColors
     */
    public function setColor(ProductColorInterface $color)
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
     * @param ProductSizesInterface $size
     *
     * @return ProductColors
     */
    public function addSize(ProductSizesInterface $size)
    {
		$size->addColor($this);
        $this->sizes[] = $size;

        return $this;
    }

    /**
     * Remove size
     *
     * @param ProductSizesInterface $size
     */
    public function removeSize(ProductSizesInterface $size)
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
