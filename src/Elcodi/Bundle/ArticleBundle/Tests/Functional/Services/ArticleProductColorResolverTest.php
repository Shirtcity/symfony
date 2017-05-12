<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Article\Services\ArticleProductColorResolver;

/**
 * Class ArticleProductColorResolverTest.
 */
class ArticleProductColorResolverTest extends WebTestCase
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
    public function testResolveArticleProductColor() {        

        $article = $this->find('article', 2);				
		$articleProduct = $article->getArticleProduct();
		
		$correctProductColors = $articleProduct->getProductColors();
        $wrongProductColors = $this->find('product_colors', 2);	
		
		$articleProduct->setProductColors($wrongProductColors);
		
		$articleProductColorResolver = new ArticleProductColorResolver();
		$articleProductColorResolver->resolveArticleProductColor($articleProduct);
		
        $this->assertNotEquals(
            $articleProduct
				->getProductColors()
				->getColor()
				->getName(),
            $wrongProductColors
				->getColor()
				->getName()
        );
		
		$this->assertEquals(
            $articleProduct
				->getProductColors()
				->getColor()
				->getName(),
            $correctProductColors
				->getColor()
				->getName()
        );
    }

}
