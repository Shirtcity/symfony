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
        $classNamespace = $this->getEntityNamespace();
		
        $productSize = new $classNamespace();

        $productSize
			->setEnabled(1);

        return $productSize;
    }	
}