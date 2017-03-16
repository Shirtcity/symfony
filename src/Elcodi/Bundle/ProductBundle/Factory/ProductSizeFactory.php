<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class ProductColorsFactory.
 */
class ProductSizeFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Product $product
         */
        $classNamespace = $this->getEntityNamespace();
		
        $productSize = new $classNamespace();

        $productSize
			->setName('undefined')
			->setEnabled(0);

        return $productSize;
    }	
}