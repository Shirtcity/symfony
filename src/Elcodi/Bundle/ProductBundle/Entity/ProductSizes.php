<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizeInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizesInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;

/**
 * ProductSizes
 */
class ProductSizes implements ProductSizesInterface
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
     * @param ProductInterface $product
     *
     * @return ProductSizes
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
     * Set size
     *
     * @param ProductSizeInterface $size
     *
     * @return ProductSizes
     */
    public function setSize(ProductSizeInterface $size)
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
     * @param ProductColorsInterface $color
     *
     * @return ProductSizes
     */
    public function addColor(ProductColorsInterface $color)
    {
        $this->colors[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param ProductColorsInterface $color
     */
    public function removeColor(ProductColorsInterface $color)
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
