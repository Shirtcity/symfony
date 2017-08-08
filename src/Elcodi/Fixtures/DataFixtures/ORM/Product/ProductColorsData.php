<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ProductColorsData
 */
class ProductColorsData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $productColorsFactory = $this->getFactory('product_colors');
        $productObjectManager = $this->get('elcodi.object_manager.product_colors');
        
        $productTshirt = $this->getReference('product-t-shirt');
        $productColorBlack = $this->getReference('product-color-black');
        
        $productColors = $productColorsFactory->create();
        
        $productColors
            ->setColor($productColorBlack)
            ->setProduct($productTshirt);

        $productObjectManager->persist($productColors);

        $this->addReference('product-colors-t-shirt-black', $productColors);
        $productObjectManager->flush($productColors);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductColorData',
        ];
    }
}
