<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

/**
 * Interface PrintSideAreaInterface.
 */
interface PrintSideAreaInterface
{
	/**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return PrintSideArea
     */
    public function setWidth($width);

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth();

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return PrintSideArea
     */
    public function setHeight($height);

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight();

    /**
     * Set posX
     *
     * @param integer $posX
     *
     * @return PrintSideArea
     */
    public function setPosX($posX);

    /**
     * Get posX
     *
     * @return integer
     */
    public function getPosX();

    /**
     * Set posY
     *
     * @param integer $posY
     *
     * @return PrintSideArea
     */
    public function setPosY($posY);

    /**
     * Get posY
     *
     * @return integer
     */
    public function getPosY();

    /**
     * Set side
     *
     * @param PrintSide $side
     *
     * @return PrintSideArea
     */
    public function setSide(PrintSideInterface $side);

    /**
     * Get side
     *
     * @return PrintSide
     */
    public function getSide();
}
