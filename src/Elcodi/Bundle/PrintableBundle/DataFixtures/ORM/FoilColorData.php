<?php

namespace Elcodi\Bundle\PrintableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class FoilColorData.
 */
class FoilColorData extends AbstractFixture implements DependentFixtureInterface
{
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $foilColorDirector = $this->getDirector('foilcolor');
        
        $foilColor = $foilColorDirector
            ->create()
			->setCode('#000')
            ->setName('black')
            ->setEnabled(true);

        $foilColorDirector->save($foilColor);
        $this->addReference('foilcolor', $foilColor);

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
        ];
    }
}
