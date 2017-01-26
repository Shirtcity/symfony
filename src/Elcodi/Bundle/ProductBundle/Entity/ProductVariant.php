<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;

/**
 * ProductVariant
 */
class ProductVariant
{
	use DateTimeTrait;
	
	/**
     * @var Product
     *
     * Parent product
     */
    protected $product;
	
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $sizeId;

    /**
     * @var integer
     */
    private $colorId;

    /**
     * @var boolean
     */
    private $active;


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
     * Set sizeId
     *
     * @param integer $sizeId
     *
     * @return ProductVariant
     */
    public function setSizeId($sizeId)
    {
        $this->sizeId = $sizeId;

        return $this;
    }

    /**
     * Get sizeId
     *
     * @return integer
     */
    public function getSizeId()
    {
        return $this->sizeId;
    }

    /**
     * Set colorId
     *
     * @param integer $colorId
     *
     * @return ProductVariant
     */
    public function setColorId($colorId)
    {
        $this->colorId = $colorId;

        return $this;
    }

    /**
     * Get colorId
     *
     * @return integer
     */
    public function getColorId()
    {
        return $this->colorId;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return ProductVariant
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set product
     *
     * @param \Elcodi\Bundle\ProductBundle\Entity\Product $product
     *
     * @return ProductVariant
     */
    public function setProduct(\Elcodi\Bundle\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Elcodi\Bundle\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
