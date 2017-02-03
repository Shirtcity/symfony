<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Article\Entity\Traits\DimensionsTrait;

use \Elcodi\Bundle\ProductBundle\Entity\ProductColors;
use \Elcodi\Bundle\ProductBundle\Entity\ProductSizes;

/**
 * Product
 */
class Product
{
	use DateTimeTrait,
        ETaggableTrait,
        MetaDataTrait,
        ImagesContainerTrait,
        PrincipalImageTrait,
        EnabledTrait,
        DimensionsTrait;
	
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $deleted;

    /**
     * @var string
     */
    private $name;
	
	/**
     * @var string
     */
    private $slug;
	
	/**
     * @var string
     *
     * Description
     */
    protected $description;
	
	/**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $colors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sizes;
	
	/**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Product
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
	
	/**
     * Set name
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
	
	public function getVariantsArray()
	{
		$variants = array();
		
		foreach ($this->sizes as $size) {
			foreach ($size->getColors() as $color) {
				$variants[$size->getSize()->getId()][$color->getColor()->getId()] = true;
			}
		}
		
		return $variants;
	}

    /**
     * Add color
     *
     * @param ProductColors $color
     *
     * @return Product
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

    /**
     * Add size
     *
     * @param ProductSizes $size
     *
     * @return Product
     */
    public function addSize(ProductSizes $size)
    {
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
	
	/**
     * To string method.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
