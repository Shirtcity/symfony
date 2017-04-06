<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\ETaggableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

use Elcodi\Bundle\PriceBundle\Entity\Interfaces\PriceInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizesInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductManufacturerInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintMethodInterface;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;

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
    DimensionableInterface,
	PriceInterface
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
     * Get Colors
     *
     * @return Collection
     */
    public function getColors();
	
	/**
	 * Set Colors
	 * @param ArrayCollection $colors
	 * @return $this
	 */
	public function setColors(ArrayCollection $colors);
	
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
	 * Set sizes
	 * 
	 * @param ArrayCollection $sizes
	 * @return $this
	 */
	public function setSizes(ArrayCollection $sizes);
	
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
	
	/**
     * Add productSide
     *
     * @param PrintSideInterface $productSide
     *
     * @return Product
     */
    public function addPrintSide(PrintSideInterface $productSide);

    /**
     * Remove productSide
     *
     * @param PrintSideInterface $productSide
     */
    public function removePrintSide(PrintSideInterface $productSide);

    /**
     * Get productSides
     *
     * @return Collection
     */
    public function getPrintSides();
	
	/**
	 * Set print sides
	 * 
	 * @param ArrayCollection $printSides
	 * @return $this
	 */	
	public function setPrintSides(ArrayCollection $printSides);
	
	/**
     * Add printMethod
     *
     * @param PrintMethodInterface $printMethod
     *
     * @return Product
     */
    public function addPrintMethod(PrintMethodInterface $printMethod);

    /**
     * Remove printMethod
     *
     * @param PrintMethodInterface $printMethod
     */
    public function removePrintMethod(PrintMethodInterface $printMethod);

    /**
     * Get printMethods
     *
     * @return Collection
     */
    public function getPrintMethods();
	
	/**
     * Add section
     *
     * @param CategoryInterface $section
     *
     * @return Product
     */
    public function addSection(CategoryInterface $section);

    /**
     * Remove section
     *
     * @param CategoryInterface $section
     */
    public function removeSection(CategoryInterface $section);

    /**
     * Get sections
     *
     * @return Collection
     */
    public function getSections();

    /**
     * Add productCategory
     *
     * @param CategoryInterface $productCategory
     *
     * @return Product
     */
    public function addProductCategory(CategoryInterface $productCategory);

    /**
     * Remove productCategory
     *
     * @param CategoryInterface $productCategory
     */
    public function removeProductCategory(CategoryInterface $productCategory);

    /**
     * Get productCategories
     *
     * @return Collection
     */
    public function getProductCategories();
	
	/**
	 * Return Product Sizes and Colors variants.
	 * 
	 * @return array
	 */
	public function getVariants();
	
	/**
	 * Set Product Sizes and Colors variants.
	 * 
	 * @return $this
	 */
	public function setVariants();
	
	/**
     * To string method.
     *
     * @return string
     */
    public function __toString();
}
