<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface ProductSizesInterface.
 */
interface ProductSizesInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set product
     *
     * @param ProductInterface $product
     *
     * @return ProductSizes
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct();

    /**
     * Set size
     *
     * @param ProductSizeInterface $size
     *
     * @return ProductSizes
     */
    public function setSize(ProductSizeInterface $size);

    /**
     * Get size
     *
     * @return ProductSize
     */
    public function getSize();

    /**
     * Add color
     *
     * @param ProductColorsInterface $color
     *
     * @return ProductSizes
     */
    public function addColor(ProductColorsInterface $color);

    /**
     * Remove color
     *
     * @param ProductColorsInterface $color
     */
    public function removeColor(ProductColorsInterface $color);

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColors();
}
