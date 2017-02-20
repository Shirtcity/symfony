<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

use Elcodi\Bundle\PriceBundle\Wrapper\DefaultPricesWrapper;
use Elcodi\Bundle\ProductBundle\Entity\Product;


/**
 * Class ProductFactory.
 */
class ProductFactory extends AbstractFactory
{
	/**
     * @var DefaultPricesWrapper
     *
     * Default prices wrapper
     */
    protected $defaultPricesWrapper;
	
	/**
     * Factory constructor.
     *
     * @param DefaultPricesWrapper $defaultPricesWrapper Default prices wrapper
     */
    public function __construct(DefaultPricesWrapper $defaultPricesWrapper)
    {
        $this->defaultPricesWrapper = $defaultPricesWrapper;
    }
	
	public function create()
    {		
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
		
		$prices = $this->createDefaultPrices();
        $product = new $classNamespace();

        $product
			->setImages(new ArrayCollection())
			->setSizes(new ArrayCollection())
			->setColors(new ArrayCollection())
			->setPrices($prices)
			->setWidth(0)
            ->setHeight(0)
			->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $product;
    }	
	
	/**
     * Returns a default prices Collection
     *
     * @return ArrayCollection
     */
    protected function createDefaultPrices()
    {
        return $this
            ->defaultPricesWrapper
            ->get();
    }
}