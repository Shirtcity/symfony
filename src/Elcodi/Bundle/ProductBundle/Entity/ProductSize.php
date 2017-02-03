<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizeInterface;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * ProductSize
 */
class ProductSize implements ProductSizeInterface
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
    private $orderAsc;


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
     * @return Size
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
     * Set orderAsc
     *
     * @param string $orderAsc
     *
     * @return Size
     */
    public function setOrderAsc($orderAsc)
    {
        $this->orderAsc = $orderAsc;

        return $this;
    }

    /**
     * Get orderAsc
     *
     * @return string
     */
    public function getOrderAsc()
    {
        return $this->orderAsc;
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
