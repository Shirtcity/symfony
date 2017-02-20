<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

/**
 * PrintSide
 */
class PrintSide implements PrintSideInterface
{
	use EnabledTrait;
	
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $position;
	
	/**
     * @var Product
     */
    private $product;


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
     * Set position
     *
     * @param string $position
     *
     * @return PrintSide
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
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
}
