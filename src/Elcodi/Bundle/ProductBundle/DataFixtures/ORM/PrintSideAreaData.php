<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideAreaData.
 */
class PrintSideAreaData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $printSideAreaDirector = $this->getDirector('print_side_area');
        
        $printSide = $this->getReference('printSide');

        $printSideArea = $printSideAreaDirector
            ->create()
            ->setWidth(200)
            ->setHeight(300)
            ->setPosX(155)
            ->setPosY(100)
            ->setSide($printSide);

        $printSideAreaDirector->save($printSideArea);
        $this->addReference('printSideArea', $printSideArea);
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
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideData',
        ];
    }
}
