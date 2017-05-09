<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideTypeData.
 */
class PrintSideTypeData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $printSideTypeDirector = $this->getDirector('print_side_type');

        $printSideTypeFront = $printSideTypeDirector
            ->create()
            ->setName('front');

        $printSideTypeDirector->save($printSideTypeFront);
        $this->addReference('print-side-type-front', $printSideTypeFront);
		
		$printSideTypeBack = $printSideTypeDirector
            ->create()
            ->setName('back');

        $printSideTypeDirector->save($printSideTypeBack);
        $this->addReference('print-side-type-back', $printSideTypeBack);
		
		$printSideTypeLeft = $printSideTypeDirector
            ->create()
            ->setName('left');

        $printSideTypeDirector->save($printSideTypeLeft);
        $this->addReference('print-side-type-left', $printSideTypeLeft);
		
		$printSideTypeRight = $printSideTypeDirector
            ->create()
            ->setName('right');

        $printSideTypeDirector->save($printSideTypeRight);
        $this->addReference('print-side-type-right', $printSideTypeRight);
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
