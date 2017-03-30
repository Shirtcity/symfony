<?php

namespace Elcodi\Bundle\ProductBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Elcodi\Component\Core\Entity\Traits\ExistsTrait;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideTypeInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface;

/**
 * PrintSide
 */
class PrintSide implements PrintSideInterface
{
	use EnabledTrait,
		SoftDeleteableEntity,
		ExistsTrait;
	
    /**
     * @var integer
     */
    private $id;
	
	/**
     * @var Product
     */
    private $product;
	
	/**
     * @var PrintSideType
     */
    private $type;


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
     * Set type
     *
     * @param PrintSideTypeInterface $type
     *
     * @return PrintSide
     */
    public function setType(PrintSideTypeInterface $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return PrintSideType
     */
    public function getType()
    {
        return $this->type;
    }
	
	/**
	 * Set Product
	 * 
	 * @param ProductInterface $product
	 * @return $this
	 */
	public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;

        return $this;
    }
}
