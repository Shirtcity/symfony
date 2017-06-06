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
     * Returns the Entity Type
     * 
     * @return string
     */
    public function getType();
}