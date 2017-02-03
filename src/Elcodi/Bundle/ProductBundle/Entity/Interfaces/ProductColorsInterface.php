<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface ProductColorsInterface.
 */
interface ProductColorsInterface
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
     * @return ProductColors
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct();

    /**
     * Set color
     *
     * @param ProductColorInterface $color
     *
     * @return ProductColors
     */
    public function setColor(ProductColorInterface $color);

    /**
     * Get color
     *
     * @return ProductColor
     */
    public function getColor();

    /**
     * Add size
     *
     * @param ProductSizesInterface $size
     *
     * @return ProductColors
     */
    public function addSize(ProductSizesInterface $size);

    /**
     * Remove size
     *
     * @param ProductSizesInterface $size
     */
    public function removeSize(ProductSizesInterface $size);

    /**
     * Get sizes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSizes();
}
