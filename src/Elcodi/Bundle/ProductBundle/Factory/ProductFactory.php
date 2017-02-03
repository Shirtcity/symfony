<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;


/**
 * Class ProductFactory.
 */
class ProductFactory extends AbstractPurchasableFactory
{
	public function create()
    {
		$zeroPrice = $this->createZeroAmountMoney();
		
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
		
        $product = new $classNamespace();

        $product
			->setImages(new ArrayCollection())
			->setSizes(new ArrayCollection())
			->setColors(new ArrayCollection())
			->setPrice($zeroPrice)
			->setWidth(0)
            ->setHeight(0)
			->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $product;
    }	
}