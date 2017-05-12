<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ProductColorsData.
 */
class ProductColorsData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $productColorsDirector = $this->getDirector('product_colors');
        
        $product = $this->getReference('product');
        $productColor = $this->getReference('product-color-white');        

        $productColors = $productColorsDirector
            ->create()
            ->setProduct($product)
            ->setColor($productColor);

        $productColorsDirector->save($productColors);
        $this->addReference('product-colors', $productColors);
		
		$productChildren = $this->getReference('product-children');
		$productChildrenColor = $this->getReference('product-color-grey');     
		
		$productChildrenColors = $productColorsDirector
            ->create()
            ->setProduct($productChildren)
            ->setColor($productChildrenColor);

        $productColorsDirector->save($productChildrenColors);
		
		
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
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductColorData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
        ];
    }
}
