<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PhotoInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * Photo
 */
class Photo extends AbstractPrintable implements PhotoInterface
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
     * @return Photo
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
        return 'Photo';
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
     * @var \Elcodi\Component\User\Entity\Customer
     */
    private $customer;


    /**
     * Set customer
     *
     * @param \Elcodi\Component\User\Entity\Customer $customer
     *
     * @return Photo
     */
    public function setCustomer(\Elcodi\Component\User\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Elcodi\Component\User\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
