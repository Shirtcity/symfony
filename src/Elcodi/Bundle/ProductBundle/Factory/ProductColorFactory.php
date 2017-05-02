<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class ProductColorsFactory.
 */
class ProductColorFactory extends AbstractFactory
{
	public function create()
    {
        $classNamespace = $this->getEntityNamespace();
		
        $productColor = new $classNamespace();

        $productColor
			->setName('undefined')
			->setCode(null)
			->setEnabled(0);

        return $productColor;
    }	
}