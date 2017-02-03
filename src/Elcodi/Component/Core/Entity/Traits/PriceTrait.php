<?php

namespace Elcodi\Component\Core\Entity\Traits;

/**
 * Trait PriceTrait.
 *
 * Trait that defines common price members
 */
trait PriceTrait
{
    /**
     * @var int
     *
     * Price
     */
    protected $price;

    /**
     * @var \Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface
     *
     * Price currency
     */
    protected $priceCurrency;


    /**
     * Set price.
     *
     * @param \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount Price
     *
     * @return $this Self object
     */
    public function setPrice(\Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface $amount)
    {
        $this->price = $amount->getAmount();
        $this->priceCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Get price.
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Price
     */
    public function getPrice()
    {		
        return \Elcodi\Component\Currency\Entity\Money::create(
            $this->price,
            $this->priceCurrency
        );
    }


    /**
     * Get price.
     *
     * @return \Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface Reduced Price
     */
    public function getResolvedPrice()
    {
        return $this->inOffer()
            ? $this->getPrice()
            : $this->getPrice();
    }

    /**
     * Is in offer.
     *
     * @return bool it is in offer
     */
    public function inOffer()
    {
        return $this->reducedPrice > 0;
    }
}
