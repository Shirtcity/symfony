<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class ProductFactory.
 */
class ProductFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
		
        $product = new $classNamespace();

        $product
            ->setVariants(new ArrayCollection())  
			->setImages(new ArrayCollection())
			->setWidth(0)
            ->setHeight(0)
			->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $product;
    }	
}