<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideTypeInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideProductColorsInterface;

/**
 * Interface PrintSideInterface.
 */
interface PrintSideInterface 
    extends 
    EnabledInterface,
    ImagesContainerInterface
{
	/**
     * Get id
	 * 
     * @return integer
     */
    public function getId();

    /**
     * Set type
     *
     * @param PrintSideTypeInterface $type
     *
     * @return PrintSide
     */
    public function setType(PrintSideTypeInterface $type = null);

    /**
     * Get type
     *
     * @return PrintSideType
     */
    public function getType();
	
	/**
	 * Set Product
	 * 
	 * @param ProductInterface $product
	 * @return $this
	 */
	public function setProduct(ProductInterface $product = null);

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct();

    /**
     * Add area
     *
     * @param PrintSideArea $area
     *
     * @return PrintSide
     */
    public function addArea(PrintSideAreaInterface $area);

    /**
     * Remove area
     *
     * @param PrintSideArea $area
     */
    public function removeArea(PrintSideAreaInterface $area);

    /**
     * Get areas
     *
     * @return Collection
     */
    public function getAreas();
	
	/**
     * Check if at least one print area exists
     *
     * @return boolean
     */
	public function hasAreas();
	
	/**
     * Get Image.
     *
     * @return ImageInterface Image
     */
    public function getImage();

    /**
     * Sets Image.
     *
     * @param ImageInterface $image Image
     *
     * @return $this Self object
     */
    public function setImage(ImageInterface $image = null);

    /**
     * Add sideProductColor
     *
     * @param PrintSideProductColorsInterface $sideProductColor
     *
     * @return PrintSide
     */
    public function addSideProductColor(PrintSideProductColorsInterface $sideProductColor);

    /**
     * Remove sideProductColor
     *
     * @param PrintSideProductColorsInterface $sideProductColor
     */
    public function removeSideProductColor(PrintSideProductColorsInterface $sideProductColor);

    /**
     * Get sideProductColors
     *
     * @return Collection
     */
    public function getSideProductColors();
}
