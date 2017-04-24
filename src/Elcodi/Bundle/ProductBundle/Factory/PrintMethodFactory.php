<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class PrintMethodFactory.
 */
class PrintMethodFactory extends AbstractFactory
{
	public function create()
    {
        $classNamespace = $this->getEntityNamespace();
		
        $printMethod = new $classNamespace();

        return $printMethod;
    }	
}