<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ProductSizesData.
 */
class ProductSizesData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $productSizesDirector = $this->getDirector('product_sizes');
        
        $product = $this->getReference('product');
        $productSize = $this->getReference('product-size');

        $productSizes = $productSizesDirector
            ->create()
            ->setProduct($product)
            ->setSize($productSize);

        $productSizesDirector->save($productSizes);
        $this->addReference('product-sizes', $productSizes);
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
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductSizeData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
        ];
    }
}
