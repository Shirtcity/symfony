<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintMethodInterface;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * PrintMethod
 */
class PrintMethod implements PrintMethodInterface
{
	use EnabledTrait;
	
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $hexcode;


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
     * Set name
     *
     * @param string $name
     *
     * @return PrintMethod
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hexcode
     *
     * @param string $hexcode
     *
     * @return PrintMethod
     */
    public function setHexcode($hexcode)
    {
        $this->hexcode = $hexcode;

        return $this;
    }

    /**
     * Get hexcode
     *
     * @return string
     */
    public function getHexcode()
    {
        return $this->hexcode;
    }
}

