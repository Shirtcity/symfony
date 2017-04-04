<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

/**
 * PrintSideProductColors
 */
class PrintSideProductColors implements PrintSideProductColorsInterface
{
    /**
     * @var integer
     */
    private $id;
	
	/**
     * @var ProductColorsInterface
     *
     * ProductColors
     */
    protected $productColors;
	
	/**
     * @var ImageInterface
     *
     * PrintSide image
     */
    protected $image;
	
	/**
     * @var PrintSideInterface
     */
    private $side;


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
     * Set productColors
     *
     * @param ProductColorsInterface $productColors
     *
     * @return PrintSideProductColors
     */
    public function setProductColors(ProductColorsInterface $productColors = null)
    {
        $this->productColors = $productColors;

        return $this;
    }

    /**
     * Get productColors
     *
     * @return ProductColorsInterface
     */
    public function getProductColors()
    {
        return $this->productColors;
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
     * Set side
     *
     * @param PrintSideInterface $side
     *
     * @return PrintSideProductColors
     */
    public function setSide(PrintSideInterface $side)
    {
        $this->side = $side;

        return $this;
    }

    /**
     * Get side
     *
     * @return PrintSideInterface
     */
    public function getSide()
    {
        return $this->side;
    }
}
