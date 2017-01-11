<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;


/**
 * Class FontFactory.
 */
class FontFactory extends AbstractFactory
{
	public function create()
    {
        /**
         * @var FoilColor $foilColor
         */
        $classNamespace = $this->getEntityNamespace();
		
        $foilColor = new $classNamespace();

        $foilColor->setEnabled(true);

        return $foilColor;
    }	
}