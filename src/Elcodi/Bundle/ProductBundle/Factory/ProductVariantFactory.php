<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\ProductBundle\Entity\ProductVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class ProductVariantFactory.
 */
class ProductVariantFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var ProductVariant $productVariant
         */
        $classNamespace = $this->getEntityNamespace();
		
        $productVariant = new $classNamespace();

        $productVariant
            //->setVariants(new ArrayCollection())            
            ->setCreatedAt($this->now());

        return $productVariant;
    }	
}