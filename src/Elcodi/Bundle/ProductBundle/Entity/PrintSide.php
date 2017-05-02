<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Elcodi\Component\Core\Entity\Traits\ExistsTrait;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideTypeInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideProductColorsInterface;

/**
 * PrintSide
 */
class PrintSide implements PrintSideInterface
{
	use EnabledTrait,
		SoftDeleteableEntity,
		ExistsTrait,
        ImagesContainerTrait;
	
    /**
     * @var integer
     */
    private $id;
	
	/**
     * @var Product
     */
    private $product;
	
	/**
     * @var PrintSideType
     */
    private $type;
	
	/**
     * @var Collection
     */
    private $areas;
	
	/**
     * @var ImageInterface
     *
     * PrintSide image
     */
    protected $image;
	
	/**
     * @var Collection
     */
	protected $sideProductColors;


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
     * Set type
     *
     * @param PrintSideTypeInterface $type
     *
     * @return PrintSide
     */
    public function setType(PrintSideTypeInterface $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return PrintSideType
     */
    public function getType()
    {
        return $this->type;
    }
	
	/**
	 * Set Product
	 * 
	 * @param ProductInterface $product
	 * @return $this
	 */
	public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * Add area
     *
     * @param PrintSideArea $area
     *
     * @return PrintSide
     */
    public function addArea(PrintSideAreaInterface $area)
    {
		$area->setSide($this);
		
        $this->areas[] = $area;

        return $this;
    }

    /**
     * Remove area
     *
     * @param PrintSideArea $area
     */
    public function removeArea(PrintSideAreaInterface $area)
    {
        $this->areas->removeElement($area);
    }

    /**
     * Get areas
     *
     * @return Collection
     */
    public function getAreas()
    {
        return $this->areas;
    }
	
	/**
     * Check if at least one print area exists
     *
     * @return boolean
     */
	public function hasAreas()
	{
		return count($this->getAreas()) > 0 ? true : false;
	}
	
	/**
     * Get Image.
     *
     * @return ImageInterface Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets Image.
     *
     * @param ImageInterface $image Image
     *
     * @return $this Self object
     */
    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Add sideProductColor
     *
     * @param PrintSideProductColorsInterface $sideProductColor
     *
     * @return PrintSide
     */
    public function addSideProductColor(PrintSideProductColorsInterface $sideProductColor)
    {
        $this->sideProductColors[] = $sideProductColor;

        return $this;
    }

    /**
     * Remove sideProductColor
     *
     * @param PrintSideProductColorsInterface $sideProductColor
     */
    public function removeSideProductColor(PrintSideProductColorsInterface $sideProductColor)
    {
        $this->sideProductColors->removeElement($sideProductColor);
    }

    /**
     * Get sideProductColors
     *
     * @return Collection
     */
    public function getSideProductColors()
    {
        return $this->sideProductColors;
    }
	
}
