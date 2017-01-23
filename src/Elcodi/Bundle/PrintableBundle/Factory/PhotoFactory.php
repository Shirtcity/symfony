<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\Photo;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class PhotoFactory.
 */
class PhotoFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Photo $photo
         */
        $classNamespace = $this->getEntityNamespace();
		
        $photo = new $classNamespace();

        $photo->setEnabled(true)
             ->setCreatedAt($this->now())
            ->setPosX(0)
            ->setPosY(0);

        return $photo;
    }	
}