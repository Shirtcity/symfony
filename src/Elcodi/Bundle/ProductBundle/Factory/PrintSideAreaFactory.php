<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class PrintSideAreaFactory.
 */
class PrintSideAreaFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var PrintSideArea $productColor
         */
        $classNamespace = $this->getEntityNamespace();
		
        $productColor = new $classNamespace();

        $productColor
			->setWidth(100)
			->setHeight(100)
			->setPosX(100)
			->setPosY(100);

        return $productColor;
    }	
}