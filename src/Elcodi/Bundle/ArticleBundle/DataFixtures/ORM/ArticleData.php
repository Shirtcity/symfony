<?php

namespace Elcodi\Bundle\ArticleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Article\Entity\ArticleProduct;
use Elcodi\Component\Article\Entity\ArticleProductPrintSide;
use Elcodi\Bundle\PrintableBundle\Entity\DesignVariant;
use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;

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
		$this->loadSimpleArticle();
		$this->loadArticleWithPrintables();
		$this->loadArticleWithSectionCategories();
    }
	
	/**
	 * Loads Fixtures for simple article
	 */
	private function loadSimpleArticle()
	{
		$product = $this->getReference('product');
		$productColors = $this->getReference('product-colors');
		
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
		
        $articleDirector->save($article);
        $this->addReference('article', $article);
	}
	
	/**
	 * Loads fixtures for an article with printables
	 */
	private function loadArticleWithPrintables()
	{
		$product = $this->getReference('product');
		$productColors = $this->getReference('product-colors');
		
        $articleDirector = $this->getDirector('article');
		
		$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct($product)
            ->setProductColors($productColors)
			->setArticleProductPrintSides(new ArrayCollection());
		
		$productPrintSide = $product
			->getPrintSides()
			->first();
		
		$articleProductPrintSide = new ArticleProductPrintSide();
		$articleProductPrintSide
			->setArticleProduct($articleProduct)
			->setPrintSide($productPrintSide)
			->setPrintableVariants(new ArrayCollection());
	
		
		$printableVariantDesign = new DesignVariant();
		$design = $this->getReference('design');
		
		$printableVariantDesign
			->setDesign($design)
			->setPosX(10)
			->setPosY(10)
            ->setWidth(100)
            ->setHeight(100);
		
		$articleProductPrintSide->addPrintableVariant($printableVariantDesign);		
		
		$printableVariantText = new TextVariant();
		$text = $this->getReference('text');
		
		$printableVariantText
			->setText($text)
			->setPosX(10)
			->setPosY(10)
            ->setWidth(20)
            ->setHeight(100);
		
		$articleProductPrintSide->addPrintableVariant($printableVariantText);			
		
		$articleProduct->addArticleProductPrintSide($articleProductPrintSide);
		
        $articleWithPrintables = $articleDirector
            ->create()
            ->setName('Article with printables')
            ->setSlug('article-with-printables')
            ->setShowInHome(true)
            ->setEnabled(true)
			->setArticleProduct($articleProduct);
	
        $articleDirector->save($articleWithPrintables);
        $this->addReference('article-with-printables', $articleWithPrintables);
	}
	
	/**
	 * Loads fixtures for an article with section categories
	 */
	private function loadArticleWithSectionCategories()
	{
		$product = $this->getReference('product');
		$productColors = $this->getReference('product-colors');
		
        $articleDirector = $this->getDirector('article');
		
		$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct($product)
            ->setProductColors($productColors);
		
        $sectionCategoryArticle = $articleDirector
            ->create()
            ->setName('Article with section category')
            ->setSlug('article-with-section-category')
            ->setEnabled(true)
			->setArticleProduct($articleProduct);

        $articleDirector->save($sectionCategoryArticle);
        $this->addReference('section-category-article', $sectionCategoryArticle);
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
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideAreaData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideProductColorsData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideTypeData',
			'Elcodi\Bundle\CategoryBundle\DataFixtures\ORM\CategoryData',
			'Elcodi\Bundle\PrintableBundle\DataFixtures\ORM\DesignData',
			'Elcodi\Bundle\PrintableBundle\DataFixtures\ORM\TextData',
        ];
    }
}
