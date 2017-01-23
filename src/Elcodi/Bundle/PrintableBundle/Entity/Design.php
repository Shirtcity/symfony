<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Elcodi\Component\User\Entity\Customer;

/**
 * Design
 */
class Design extends AbstractPrintable implements DesignInterface
{
    use DateTimeTrait,
        EnabledTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * @return Design
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
     * Get the Type
     *
     * @return string
     */
    public function getType(){
        return 'Design';
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $foilcolor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->foilcolor = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add foilcolor
     *
     * @param FoilColor $foilcolor
     *
     * @return Design
     */
    public function addFoilcolor(FoilColor $foilcolor)
    {
        $this->foilcolor[] = $foilcolor;

        return $this;
    }

    /**
     * Remove foilcolor
     *
     * @param FoilColor $foilcolor
     */
    public function removeFoilcolor(FoilColor $foilcolor)
    {
        $this->foilcolor->removeElement($foilcolor);
    }

    /**
     * Get foilcolor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoilcolor()
    {
        return $this->foilcolor;
    }
    /**
     * @var Customer
     */
    private $customer;


    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return Design
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
