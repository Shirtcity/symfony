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
            ->setOrderAsc(0)
			->setEnabled(true);

        return $productSize;
    }	
}