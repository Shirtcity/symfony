<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\PhotoVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class PhotoFactory.
 */
class PhotoVariantFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var PhotoVariant $photoVariant
         */
        $classNamespace = $this->getEntityNamespace();
		
        $photoVariant = new $classNamespace();

        $photoVariant->setEnabled(true)
             ->setCreatedAt($this->now())
            ->setPosX(0)
            ->setPosY(0);

        return $photoVariant;
    }	
}