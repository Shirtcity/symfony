<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

/**
 * PrintSideArea
 */
class PrintSideArea implements PrintSideAreaInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $posX;

    /**
     * @var integer
     */
    private $posY;
	
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
     * Set width
     *
     * @param integer $width
     *
     * @return PrintSideArea
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return PrintSideArea
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set posX
     *
     * @param integer $posX
     *
     * @return PrintSideArea
     */
    public function setPosX($posX)
    {
        $this->posX = $posX;

        return $this;
    }

    /**
     * Get posX
     *
     * @return integer
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * Set posY
     *
     * @param integer $posY
     *
     * @return PrintSideArea
     */
    public function setPosY($posY)
    {
        $this->posY = $posY;

        return $this;
    }

    /**
     * Get posY
     *
     * @return integer
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * Set side
     *
     * @param PrintSide $side
     *
     * @return PrintSideArea
     */
    public function setSide(PrintSideInterface $side)
    {
        $this->side = $side;

        return $this;
    }

    /**
     * Get side
     *
     * @return PrintSide
     */
    public function getSide()
    {
        return $this->side;
    }
}
