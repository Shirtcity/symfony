<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\Design;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class DesignFactory.
 */
class DesignFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Design $design
         */
        $classNamespace = $this->getEntityNamespace();
		
        $design = new $classNamespace();

        $design->setEnabled(true)
             ->setCreatedAt($this->now())
            ->setPosX(0)
            ->setPosY(0);

        return $design;
    }	
}