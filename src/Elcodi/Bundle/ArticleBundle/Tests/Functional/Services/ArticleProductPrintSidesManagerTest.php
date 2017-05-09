<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Article\Services\ArticleProductPrintSidesManager;

/**
 * Class ArticleProductPrintSidesManagerTest.
 */
class ArticleProductPrintSidesManagerTest extends WebTestCase
{	
	/**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiArticleBundle',
        ];
    }
	
    /**
     * Test resolve ArticleProduct color.
     */
    public function testPreSetArticleProductPrintSides() {        

        $article = $this->find('article', 2);				
		$articleProduct = $article->getArticleProduct();
		$existedPrintSideTypes = $this->findAll('print_side_type');
		
		$printSideTypeRepository = $this->getRepository('print_side_type');		
		$printSideFactory = $this->getFactory('print_side');		
		$articleProductPrintSideFactory = $this->getFactory('article_product_print_side');
		
		$articleProductPrintSideManager = new ArticleProductPrintSidesManager(
			$printSideTypeRepository,
			$printSideFactory,
			$articleProductPrintSideFactory	
		);
		
		$articleProductPrintSides = $articleProduct->getArticleProductPrintSides();
		$originArticleProductPrintSides = clone $articleProductPrintSides;
		
		$articleProductPrintSideManager->preSetArticleProductPrintSides($articleProduct);
				
		$this->assertGreaterThan(
            $originArticleProductPrintSides
				->count(),
            $articleProduct
				->getArticleProductPrintSides()
				->count()
        );
		
		$this->assertCount(
			count($existedPrintSideTypes),	
			$articleProduct->getArticleProductPrintSides()
		);
		
		$this->assertEquals(
			$originArticleProductPrintSides
				->first()
				->getPrintableVariants(),
			$articleProduct
				->getArticleProductPrintSides()
				->first()
				->getPrintableVariants()
		);
		
		$this->assertCount(
			2,	
			$articleProduct
				->getArticleProductPrintSides()
				->first()
				->getPrintableVariants()
		);
    }

}
