<?php

namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

use Elcodi\Bundle\ProductBundle\Entity\PrintSide;


/**
 * Class PrintSideFactory.
 */
class PrintSideFactory extends AbstractFactory
{
	public function create()
    {		
        /**
         * @var PrintSide $printSide
         */
        $classNamespace = $this->getEntityNamespace();
		
        $printSide = new $classNamespace();

        $printSide
            ->setEnabled(false);

        return $printSide;
    }
}