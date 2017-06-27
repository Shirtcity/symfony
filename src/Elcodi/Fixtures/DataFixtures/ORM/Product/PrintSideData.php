<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideData
 */
class PrintSideData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $printSideFactory = $this->getFactory('print_side');
        $objectManager = $this->get('elcodi.object_manager.print_side');
        
        $productTshirt = $this->getReference('product-t-shirt');
        $printSideType = $this->getReference('print-side-type-front');
        
        $printSide = $printSideFactory->create();
        
        $printSide
            ->setProduct($productTshirt)
            ->setType($printSideType)
            ->setEnabled(true);

        $objectManager->persist($printSide);

        $this->addReference('print-side', $printSide);
        $objectManager->flush($printSide);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\PrintSideTypeData',
        ];
    }
}
