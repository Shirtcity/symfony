<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideAreaData
 */
class PrintSideAreaData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $printSideAreaFactory = $this->getFactory('print_side_area');
        $objectManager = $this->get('elcodi.object_manager.print_side_area');
        
        $printSide = $this->getReference('print-side');
        
        $printSideArea = $printSideAreaFactory->create();
        
        $printSideArea
            ->setSide($printSide)
            ->setWidth(200)
            ->setHeight(300)
            ->setPosX(280)
            ->setPosY(120);

        $objectManager->persist($printSideArea);

        $this->addReference('print-side-area-t-shirt-front', $printSideArea);
        $objectManager->flush($printSideArea);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Fixtures\DataFixtures\ORM\Store\StoreData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\PrintSideData',
        ];
    }
}