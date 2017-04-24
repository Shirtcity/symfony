<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class ProductSizesFactory.
 */
class ProductSizesFactory extends AbstractFactory
{
	public function create()
    {
        $classNamespace = $this->getEntityNamespace();
		
        $productSizes = new $classNamespace();

        return $productSizes;
    }	
}