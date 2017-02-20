<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizesInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductManufacturerInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;

use Elcodi\Bundle\PriceBundle\Entity\Traits\PriceTrait;
use Elcodi\Bundle\ProductBundle\Entity\Traits\DimensionsTrait;


/**
 * Product
 */
class Product implements ProductInterface
{
	use DateTimeTrait,
        ETaggableTrait,
        MetaDataTrait,
        ImagesContainerTrait,
        PrincipalImageTrait,
        EnabledTrait,
        DimensionsTrait,
		PriceTrait;
	
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
     * @var Collection
     */
    private $colors;

    /**
     * @var Collection
     */
    private $sizes;
	
	/**
     * @var ProductManufacturerInterface
     *
     * ProductManufacturer
     */
    protected $product_manufacturer;
	
	/**
     * @var Collection
     */
    private $printSides;
		
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

    /**
     * Add color
     *
     * @param ProductColorsInterface $color
     *
     * @return Product
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
     * Get Colors
     *
     * @return Collection
     */
    public function getColors()
    {
        return $this->colors;
    }
	
	/**
	 * Set Colors
	 * @param ArrayCollection $colors
	 * @return $this
	 */
	public function setColors(ArrayCollection $colors)
	{
		$this->colors = $colors;

        return $this;
	}
	
	/**
	 * Return ArrayCollections of Product Colors
	 */
	public function getProductColors()
	{		
		$productColors = new ArrayCollection();		
		
		foreach($this->colors as $color){
			$productColors[$color->getId()] = $color->getColor();
		}
		
		return $productColors;
	}
    
	/**
	 * Set ProductColors
	 * 
	 * @param type ArrayCollection 
	 */
    public function setProductColors(ArrayCollection $productColors)
    {
		foreach ($this->getColors() as $color) {
			$this->removeColor($color);
		}
		
        foreach($productColors as $color) {
            $productColor = new ProductColors();

            $productColor->setProduct($this);
            $productColor->setColor($color);

            $this->addColor($productColor);
        }
    }


    /**
     * Add size
     *
     * @param ProductSizesInterface $size
     *
     * @return Product
     */
    public function addSize(ProductSizesInterface $size)
    {
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
     * @return Collection
     */
    public function getSizes()
    {
        return $this->sizes;
    }
	
	/**
	 * Set sizes
	 * 
	 * @param ArrayCollection $sizes
	 * @return $this
	 */
	public function setSizes(ArrayCollection $sizes)
	{
		$this->sizes = $sizes;

        return $this;
	}
	
	/**
	 * Return ArrayCollections of ProductSizes
	 * 
	 * @return ArrayCollection
	 */
    public function getProductSizes()
    {
        $productSizes = new ArrayCollection();
        
        foreach($this->sizes as $size) {
            $productSizes[] = $size->getSize();
        }

        return $productSizes;
    }
    
	/**
	 * Set ProductSizes
	 * 
	 * @param type ArrayCollection 
	 */
    public function setProductSizes(ArrayCollection $productSizes)
    {
		foreach ($this->getSizes() as $size) {
			$this->removeSize($size);
		}
		
        foreach($productSizes as $size) {
            $productSize = new ProductSizes();

            $productSize->setProduct($this);
            $productSize->setSize($size);

            $this->addSize($productSize);
        }
    }
	
	/**
     * Product product_manufacturer.
     *
     * @return ProductManufacturerInterface ProductManufacturer
     */
    public function getProductManufacturer()
    {
        return $this->product_manufacturer;
    }
	
	/**
     * Set product product_manufacturer.
     *
     * @param ProductManufacturerInterface $product_manufacturer ProductManufacturer
     *
     * @return $this Self object
     */
    public function setProductManufacturer(ProductManufacturerInterface $product_manufacturer = null)
    {
        $this->product_manufacturer = $product_manufacturer;

        return $this;
    }
	
	/**
     * Add productSide
     *
     * @param PrintSideInterface $productSide
     *
     * @return Product
     */
    public function addPrintSide(PrintSideInterface $productSide)
    {
        $this->printSides[] = $productSide;

        return $this;
    }

    /**
     * Remove productSide
     *
     * @param PrintSideInterface $productSide
     */
    public function removePrintSide(PrintSideInterface $productSide)
    {
        $this->printSides->removeElement($productSide);
    }

    /**
     * Get productSides
     *
     * @return Collection
     */
    public function getPrintSides()
    {
        return $this->printSides;
    }
	
	/**
	 * Return Product Sizes and Colors variants.
	 * 
	 * @return array
	 */
	public function getVariants()
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
	 * Set Product Sizes and Colors variants.
	 * 
	 * @return $this
	 */
	public function setVariants()
	{		
		foreach ($this->getSizes() as $size) {
			foreach ($this->getColors() as $color) {
				$size->addColor($color);
			}
		}
		
		return $this;
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
