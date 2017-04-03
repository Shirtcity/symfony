<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class ProductColorsFactory.
 */
class ProductColorsFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
		
        $productColors = new $classNamespace();

        return $productColors;
    }	
}