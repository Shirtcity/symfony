<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class TextVariantFactory.
 */
class TextVariantFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var TextVariant $textVariant
         */
        $classNamespace = $this->getEntityNamespace();

        $textVariant = new $classNamespace();

        $textVariant->setEnabled(true)
             ->setCreatedAt($this->now())
             ->setPosX(0)
             ->setPosY(0);

        return $textVariant;
    }	
}