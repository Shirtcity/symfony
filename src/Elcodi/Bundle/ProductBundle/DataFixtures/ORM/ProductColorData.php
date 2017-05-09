<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ProductColorData.
 */
class ProductColorData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $productColorDirector = $this->getDirector('product_color');

        $productColorWhite = $productColorDirector
            ->create()
            ->setName('white')
			->setCode('fff')
			->setEnabled(true);

        $productColorDirector->save($productColorWhite);
		$this->addReference('product-color-white', $productColorWhite);
		
		$productColorGrey = $productColorDirector
            ->create()
            ->setName('grey')
			->setCode('ccc')
			->setEnabled(true);
		
		$productColorDirector->save($productColorGrey);
		
        $this->addReference('product-color-grey', $productColorGrey);
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
