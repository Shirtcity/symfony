<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideTypeData
 */
class PrintSideTypeData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $factory = $this->getFactory('print_side_type');
        $objectManager = $this->get('elcodi.object_manager.print_side_type');
        
        $printSideType = $factory->create();
        
        $printSideType
            ->setName('front');

        $objectManager->persist($printSideType);

        $this->addReference('print-side-type-front', $printSideType);
        $objectManager->flush($printSideType);
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
        ];
    }
}
