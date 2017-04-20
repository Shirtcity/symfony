<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class PrintableVariantFactory.
 */
class PrintableVariantFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var PrintableVariant $printableVariant
         */
        $classNamespace = $this->getEntityNamespace();

        $printableVariant = new $classNamespace();

        $printableVariant
            ->setPosX(0)
            ->setPosY(0);

        return $printableVariant;
    }	
}