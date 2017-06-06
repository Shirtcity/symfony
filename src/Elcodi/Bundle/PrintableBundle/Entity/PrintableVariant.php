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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer
     */
    private $posX;

    /**
     * @var integer
     */
    private $posY;
    

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
