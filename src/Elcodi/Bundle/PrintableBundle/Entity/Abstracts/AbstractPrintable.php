<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Abstracts;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableInterface;

abstract class AbstractPrintable implements PrintableInterface
{
    /**
     * @var integer
     * 
     * Printable position X
     */
    protected $posX;
    
    /**
     * @var integer
     * 
     * Printable position Y
     */
    protected $posY; 

    /**
     * Get printable position X
     * 
     * @return integer
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * Set printable position X
     * 
     * @param integer $posX
     * 
     * @return AbstractPrintable
     */
    public function setPosX($posX)
    {
        $this->posX = $posX;
        return $this;
    }

    /**
     * Get printable position Y
     * 
     * @return integer
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * Set printable position Y
     * 
     * @param integer $posY
     * 
     * @return AbstractPrintable
     */
    public function setPosY($posY)
    {
        $this->posY = $posY;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType();
}