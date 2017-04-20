<?php

namespace Elcodi\Bundle\PrintableBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Bundle\PrintableBundle\Factory\TextFactory;


/**
 * Class TextVariantFactory.
 */
class TextVariantFactory extends AbstractFactory
{
	/**
	 * @var TextFactory 
	 */
	private $textFactory;
	
	/**
	 * Construct
	 * 
	 * @param TextFactory $textFactory
	 */
	public function __construct(TextFactory $textFactory) 
	{
		$this->textFactory = $textFactory;
	}
	
	public function create()
    {
        /**
         * @var TextVariant $textVariant
         */
        $classNamespace = $this->getEntityNamespace();

        $textVariant = new $classNamespace();

        $textVariant
             ->setPosX(0)
             ->setPosY(0)
			->setText(
				$this->textFactory->create()
			);

        return $textVariant;
    }	
}