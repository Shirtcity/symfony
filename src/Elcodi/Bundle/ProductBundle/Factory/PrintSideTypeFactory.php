<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class PrintSideTypeFactory.
 */
class PrintSideTypeFactory extends AbstractFactory
{
	public function create()
    {
        $classNamespace = $this->getEntityNamespace();
		
        $printSideType = new $classNamespace();

        return $printSideType;
    }	
}