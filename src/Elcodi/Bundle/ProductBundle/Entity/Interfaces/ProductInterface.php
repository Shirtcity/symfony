<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\ETaggableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface ProductInterface.
 */
interface ProductInterface
	extends
    DateTimeInterface,
    ETaggableInterface,
    MetaDataInterface,
    ImagesContainerWithPrincipalImageInterface,
    EnabledInterface,
    DimensionableInterface
{
	
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Product
     */
    public function setDeleted($deleted);

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted();

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();
	
	/**
     * Set name
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();

    /**
     * Add color
     *
     * @param ProductColorsInterface $color
     *
     * @return Product
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
     * @return Collection
     */
    public function getColors();

    /**
     * Add size
     *
     * @param ProductSizesInterface $size
     *
     * @return Product
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
     * @return Collection
     */
    public function getSizes();
	
	/**
	 * Return array of Products and Colors variants.
	 * 
	 * @return array
	 */
	public function getVariantsArray();
	
	/**
     * Product product_manufacturer.
     *
     * @return ProductManufacturerInterface ProductManufacturer
     */
	public function getProductManufacturer();
	
	/**
     * Set product product_manufacturer.
     *
     * @param ProductManufacturerInterface $product_manufacturer ProductManufacturer
     *
     * @return $this Self object
     */
    public function setProductManufacturer(ProductManufacturerInterface $product_manufacturer = null);
}
