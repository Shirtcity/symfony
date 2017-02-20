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

namespace Elcodi\Bundle\ArticleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\ArticleBundle\DataFixtures\ORM\Traits\ArticleWithImagesTrait;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Article\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\ArticleProduct;

use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\Entity\ProductColor;
use Elcodi\Bundle\ProductBundle\Entity\ProductSize;

/**
 * Class ArticleData.
 */
class ArticleData extends AbstractFixture implements DependentFixtureInterface
{
    use ArticleWithImagesTrait;

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Article.
         *
         * @var CategoryInterface     $category
         * @var CurrencyInterface     $currency
         * @var ObjectDirector        $articleDirector
         */
        $category = $this->getReference('category');
        $rootCategory = $this->getReference('rootCategory');
		
		$product = $this->getReference('product');
		$productColor = $this->getReference('product-color');
		$productSize = $this->getReference('product-size');
		
        $currency = $this->getReference('currency-dollar');
        $articleDirector = $this->getDirector('article');
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
		
		$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct($product)
            ->setProductColor($productColor);

        $article = $articleDirector
            ->create()
            ->setName('article')
            ->setSlug('article')
            ->setDescription('my article description')
            ->setShortDescription('my article short description')
            ->addCategory($category)
            ->setPrincipalCategory($category)
            ->setPrice(Money::create(1000, $currency))
            ->setSku('article-sku-code-1')
            ->setEnabled(true);

        $articleDirector->save($article);
        $this->addReference('article', $article);

        /**
         * Reduced Article.
         */
        $articleReduced = $articleDirector
            ->create()
            ->setName('article-reduced')
            ->setSlug('article-reduced')
            ->setDescription('my article-reduced description')
            ->setShortDescription('my article-reduced short description')
            ->setShowInHome(true)
            ->setPrice(Money::create(1000, $currency))
            ->setReducedPrice(Money::create(500, $currency))
            ->setEnabled(true)
			->setArticleProduct($articleProduct);

        $this->storeArticleImage(
            $articleReduced,
            'article.jpg'
        );

        $articleDirector->save($articleReduced);
        $this->addReference('article-reduced', $articleReduced);
        
        /**
         * Root category article.
         *
         * @var ArticleInterface $rootCategoryArticle
         */
        $rootCategoryArticle = $articleDirector
            ->create()
            ->setName('Root category article')
            ->setSlug('root-category-article')
            ->setDescription('my article description')
            ->setShortDescription('my article short description')
            ->addCategory($rootCategory)
            ->setPrincipalCategory($rootCategory)
            ->setPrice(Money::create(500, $currency))
            ->setSku('article-sku-code-3')
            ->setEnabled(true);
			//->setArticleProduct($articleProduct);

        $articleDirector->save($rootCategoryArticle);
        $this->addReference('rootCategoryArticle', $rootCategoryArticle);
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
            'Elcodi\Bundle\ArticleBundle\DataFixtures\ORM\CategoryData',
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
        ];
    }
}
