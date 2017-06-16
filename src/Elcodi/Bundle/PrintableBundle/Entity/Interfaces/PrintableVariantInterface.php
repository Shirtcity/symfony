<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Interfaces;

interface PrintableVariantInterface
{
    /**
     * Get posX
     *
     * @return integer
     */
    public function getPosX();
    
    /**
     * Set posX
     *
     * @var integer $posX
     */
    public function setPosX($posX);
    
    /**
     * Get posY
     *
     * @return integer
     */
    public function getPosY(); 
    
    /**
     * Set posY
     *
     * @var integer $posY
     */
    public function setPosY($posY);
    
    /**
     * Get printable width
     * 
     * @return integer
     */
    public function getWidth();

    /**
     * Set printable width
     * 
     * @param integer $width
     * 
     * @return AbstractPrintable
     */
    public function setWidth($width);

    /**
     * Get printable height
     * 
     * @return integer
     */
    public function getHeight();

    /**
     * Set printable height
     * 
     * @param integer $height
     * 
     * @return AbstractPrintable
     */
    public function setHeight($height);
    
    /**
     * Returns the Entity Type
     * 
     * @return string
     */
    public function getType();
}