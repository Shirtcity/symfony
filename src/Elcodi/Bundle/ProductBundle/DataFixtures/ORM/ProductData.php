<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class ProductData.
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{  

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Product
         *
         * @var CurrencyInterface     $currency
         * @var ObjectDirector        $prodcutDirector
         */
        $currency = $this->getReference('currency-dollar');
        $productReference = $this->getDirector('product');
		
		$productColor = $this->getReference('productColor');		
		$productColors = new ArrayCollection();
		$productColors[] = $productColor;
		
		$productSize = $this->getReference('productSize');
		$productSizes = new ArrayCollection();
		$productSizes[] = $productSize;
		
        $product = $productReference
            ->create()
            ->setName('T-Shirt')
            ->setSlug('t-shirt')
            ->setDescription('my T-Shirt description')
            ->setHeight(10)
			->setWidth(10)
			->setdepth(10)
			->setWeight(10)
            ->setEnabled(true)
			->setProductColors($productColors)
			->setProductSizes($productSizes);

        $productReference->save($product);
        $this->addReference('product', $product);

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
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductColorData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductSizeData',
        ];
    }
}
