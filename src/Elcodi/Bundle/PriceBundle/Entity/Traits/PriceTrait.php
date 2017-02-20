<?php

namespace Elcodi\Bundle\PriceBundle\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;

use \Elcodi\Component\Currency\Entity\Money;
use Elcodi\Bundle\PriceBundle\Entity\Interfaces\PriceInterface;
use Elcodi\Bundle\PriceBundle\Entity\Price;

/**
 * Trait PriceTrait.
 *
 * Trait that defines common price members
 */
trait PriceTrait
{
	/**
     * @var Collection
     *
     * Prices
     */
    protected $prices;
	
	/**
     * Get prices.
     *
     * @return ArrayCollection Prices
     */
    public function getPrices()
    {		
		$prices = new ArrayCollection();
		
		if($this->prices) {
			foreach($this->prices as $price) {
				$prices[] = Money::create(
					$price->getPrice(),
					$price->getPriceCurrency()
				);
			}
		}
		
        return $prices;
    }
	
	/**
	 * Set Prices
	 * 
	 * @param ArrayCollection $prices
	 * @return $this
	 */
	public function setPrices(ArrayCollection $prices)
    {		
		$this->removePrices();
		
		$this->prices = new ArrayCollection();
		
		foreach($prices as $amount) {
			$price = new Price();
			$price->setPrice($amount->getAmount());
			$price->setPriceCurrency($amount->getCurrency());			
			$this->prices[] = $price;
		}
		
		return $this;
    }
	
	/**
     * Remove price
     *
     * @param PriceInterface $price
     */
    public function removePrice(PriceInterface $price)
    {		
        $this->prices->removeElement($price);
    }
	
	/**
     * Remove already assigned prices
     */
    public function removePrices()
    {		
		if($this->prices) {
			foreach($this->prices as $price) {
				$this->removePrice($price);
			}
		}
    }
}
