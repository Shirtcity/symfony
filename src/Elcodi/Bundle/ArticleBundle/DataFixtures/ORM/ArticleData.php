<?php

namespace Elcodi\Bundle\ArticleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Article\Entity\ArticleProduct;


/**
 * Class ArticleData.
 */
class ArticleData extends AbstractFixture implements DependentFixtureInterface
{

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
		$product = $this->getReference('product');
		$productColors = $this->getReference('productColors');
		
        $currency = $this->getReference('currency-dollar');
        $articleDirector = $this->getDirector('article');
				
		$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct($product)
            ->setProductColors($productColors);

        $article = $articleDirector
            ->create()
            ->setName('article')
            ->setSlug('article')
            ->setEnabled(true)
			->setArticleProduct($articleProduct);

		$articlePrice = $this
			->get('price_resolver.article')
			->getPrice($article, $currency);
		
        $articleDirector->save($article);
        $this->addReference('article', $article);

        /**
         * Reduced Article.
         */
		
		$articleProduct1 = new ArticleProduct();
		$articleProduct1
            ->setProduct($product)
            ->setProductColors($productColors);
		
        $articleReduced = $articleDirector
            ->create()
            ->setName('article-reduced')
            ->setSlug('article-reduced')
            ->setShowInHome(true)
            ->setEnabled(true)
			->setArticleProduct($articleProduct1);

        $articleDirector->save($articleReduced);
        $this->addReference('article-reduced', $articleReduced);
       		
		$articleProduct2 = new ArticleProduct();
		$articleProduct2
            ->setProduct($product)
            ->setProductColors($productColors);
		
        $rootCategoryArticle = $articleDirector
            ->create()
            ->setName('Root category article')
            ->setSlug('root-category')
            ->setEnabled(true)
			->setArticleProduct($articleProduct2);

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
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductColorsData',
			'Elcodi\Bundle\CategoryBundle\DataFixtures\ORM\CategoryData',
        ];
    }
}
