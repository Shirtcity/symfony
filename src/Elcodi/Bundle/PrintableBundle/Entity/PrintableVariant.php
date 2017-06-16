<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;

/**
 * PrintableVariant
 */
abstract class PrintableVariant implements PrintableVariantInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $posX;

    /**
     * @var integer
     */
    private $posY;
    
    /**
     * @var integer
     * 
     * Printable width
     */
    private $width;
    
    /**
     * @var integer
     * 
     * Printable height
     */
    private $height;

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
     * Set posX
     *
     * @param integer $posX
     *
     * @return PrintableVariant
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
     * @return PrintableVariant
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
     * Get printable width
     * 
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set printable width
     * 
     * @param integer $width
     * 
     * @return AbstractPrintable
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Get printable height
     * 
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set printable height
     * 
     * @param integer $height
     * 
     * @return AbstractPrintable
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
	
	/**
	 * Returns the class name
	 * 
	 * @return string
	 */
	public function __toString() 
	{
		return 'PrintableVariant';
	}
    
    /**
     * Returns the Entity Type
     * 
     * @return string
     */
    public abstract function getType();
}
