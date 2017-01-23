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
     * @var Collection
     *
     * Variants for this aroduct
     */
    protected $variants;


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
     * Gets aroduct variants.
     *
     * @return Collection Variants
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Adds a Variant for this Product.
     *
     * @param VariantInterface $variant
     *
     * @return $this Self object
     */
    public function addVariant(ProductVariant $variant)
    {
        if (!$this
            ->variants
            ->contains($variant)) {
            $this
                ->variants
                ->add($variant);
        }

        return $this;
    }

    /**
     * Sets aroduct variants.
     *
     * @param Collection $variants Variants
     *
     * @return $this Self object
     */
    public function setVariants(Collection $variants)
    {
        $this->variants = $variants;

        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->variants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Remove variant
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\ProductVariant $variant
     */
    public function removeVariant(\Elcodi\Bundle\ProductBundle\Entity\ProductVariant $variant)
    {
        $this->variants->removeElement($variant);
    }
}
