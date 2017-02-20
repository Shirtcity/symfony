<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductManufacturerInterface;

/**
 * Class ProductManufacturer.
 */
class ProductManufacturer implements ProductManufacturerInterface
{
    use IdentifiableTrait,
        ImagesContainerTrait,
        PrincipalImageTrait,
        DateTimeTrait,
        EnabledTrait,
        MetaDataTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var Collection
     *
     * Products
     */
    protected $products;

    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get products.
     *
     * @return Collection Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add product
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\Product $product
     *
     * @return ProductManufacturer
     */
    public function addProduct(\Elcodi\Bundle\ProductBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\Product $product
     */
    public function removeProduct(\Elcodi\Bundle\ProductBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }
}
