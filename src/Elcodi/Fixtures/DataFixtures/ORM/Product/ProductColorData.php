<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ProductColorData
 */
class ProductColorData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $productColorFactory = $this->getFactory('product_color');
        $productObjectManager = $this->get('elcodi.object_manager.product_color');
        
        $productColor = $productColorFactory->create();
        
        $productColor
            ->setName('black')
            ->setCode('#000');

        $productObjectManager->persist($productColor);

        $this->addReference('product-color-black', $productColor);
        $productObjectManager->flush($productColor);
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
