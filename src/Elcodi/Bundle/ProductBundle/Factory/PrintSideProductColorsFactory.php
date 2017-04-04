<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class PrintSideProductColorsFactory.
 */
class PrintSideProductColorsFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var PrintSideProductColorsFactory $sideProductColors
         */
        $classNamespace = $this->getEntityNamespace();
		
        $sideProductColors = new $classNamespace();

        return $sideProductColors;
    }	
}