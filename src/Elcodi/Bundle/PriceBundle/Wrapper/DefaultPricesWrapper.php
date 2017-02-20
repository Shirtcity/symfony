<?php

namespace Elcodi\Bundle\PriceBundle\Wrapper;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Repository\CurrencyRepository;

use Elcodi\Component\Currency\Entity\Money;

/**
 * Class DefaultPricesWrapper.
 */
class DefaultPricesWrapper implements WrapperInterface
{	
	 /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;

    /**
     * Prices wrapper constructor.
     *
     * @param CurrencyRepository $currencyRepository     Currency repository
     */
    public function __construct(
        CurrencyRepository $currencyRepository
    ) {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * Returns the ArrayCollection Default Prices
     *
     * @return ArrayCollection Default Prices
     */
    public function get()
    {
		$prices = new ArrayCollection;
		
		$currencies = $this
			->currencyRepository
			->createQueryBuilder('c')
			->where('c.enabled = :enabled')
			->setParameter('enabled', true)
			->getQuery()
			->getResult();
		
		foreach($currencies as $currency) {	
			$prices[] = Money::create(0, $currency);
		}

        return $prices;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        return $this;
    }
}
