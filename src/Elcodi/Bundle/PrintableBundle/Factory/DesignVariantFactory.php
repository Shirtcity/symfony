<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\DesignVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class DesignVariantFactory.
 */
class DesignVariantFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var DesignVariant $designVariant
         */
        $classNamespace = $this->getEntityNamespace();
		
        $designVariant = new $classNamespace();

        $designVariant->setEnabled(true)
             ->setCreatedAt($this->now())
            ->setPosX(0)
            ->setPosY(0);

        return $designVariant;
    }	
}