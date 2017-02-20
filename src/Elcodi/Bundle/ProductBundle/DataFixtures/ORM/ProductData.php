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
        $productDirector = $this->getDirector('product');
		$productColor = $this->getReference('product-color');
		$productSize = $this->getReference('product-size');
		
		/*
		$product = new Product();		
		$productColor = new ProductColor();
		
		$productColor
			->setName('white')
			->setCode('fff')
			->setEnabled(true);
		
		$product
			->setName('T-Shirt')
			->setSlug('t-shirt')
			->setDescription('My perfect T-Shirt')
			->setHeight(10)
			->setWidth(10)
			->setdepth(10)
			->setWeight(10)
			->setEnabled(true)
			->setPrice(Money::create(1000, $currency));*/
		
		/*$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct()
            ->setProductColor();*/

        $product = $productDirector
            ->create()
            ->setName('T-Shirt')
            ->setSlug('t-shirt')
            ->setDescription('my T-Shirt description')
            ->setShortDescription('my T-Shirt short description')
            ->setHeight(10)
			->setWidth(10)
			->setdepth(10)
			->setWeight(10)
            ->setPrice(Money::create(1000, $currency))
            ->setSku('product-sku-code-1')
            ->setEnabled(true)
			->setProductColor($productColor)
			->setSize($productSize);

        $productDirector->save($product);
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
		//	'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductColorData',
		//	'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductSizeData',
        ];
    }
}
