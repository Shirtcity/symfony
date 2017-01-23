<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\Text;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;


/**
 * Class TextFactory.
 */
class TextFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var Text $text
         */
        $classNamespace = $this->getEntityNamespace();
		
        $text = new $classNamespace();

        $text->setEnabled(true)
             ->setCreatedAt($this->now())
             ->setPosX(0)
             ->setPosY(0);

        return $text;
    }	
}