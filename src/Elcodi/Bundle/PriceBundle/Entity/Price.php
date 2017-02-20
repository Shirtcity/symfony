<?php

namespace Elcodi\Bundle\PriceBundle\Entity;

use Elcodi\Bundle\PriceBundle\Entity\Interfaces\PriceInterface;

use \Elcodi\Component\Currency\Entity\Currency;

/**
 * Price
 */
class Price implements PriceInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $price;
	
	/**
     * @var Currency
     */
    private $priceCurrency;

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
     * Set price
     *
     * @param integer $price
     *
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }    


    /**
     * Set priceCurrency
     *
     * @param Currency $priceCurrency
     *
     * @return Price
     */
    public function setPriceCurrency(Currency $priceCurrency = null)
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * Get priceCurrency
     *
     * @return Currency
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }
	
	public function __toString() {
		return 'Price';
	}
}
