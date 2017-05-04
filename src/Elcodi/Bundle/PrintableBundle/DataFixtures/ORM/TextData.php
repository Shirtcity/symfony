<?php

namespace Elcodi\Bundle\PrintableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class TextData.
 */
class TextData extends AbstractFixture implements DependentFixtureInterface
{
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $textDirector = $this->getDirector('text');
		$font = $this->getReference('font');
		$foilColor = $this->getReference('foilcolor');
        
        $text = $textDirector
            ->create()
			->setFont($font)
            ->setFoilColor($foilColor)
            ->setContent('El bufalo de la noche sueña con nosotros')
            ->setEnabled(true);

        $textDirector->save($text);
        $this->addReference('text', $text);

    }
    
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
			'Elcodi\Bundle\PrintableBundle\DataFixtures\ORM\FontData',
			'Elcodi\Bundle\PrintableBundle\DataFixtures\ORM\FoilColorData',
        ];
    }
}
