<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticleProductTest
 */
class ArticleProductTest extends WebTestCase
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
     * Test article product
     */
    public function testArticleProduct()
    {
        $article = $this->find('article', 1);
        $articleProduct = $this->find('product', 1);
		
		$this->assertEquals(
            $article->getArticleProduct()->getProduct(),
            $articleProduct
        );
    }
	
	/**
     * Test article product color
     */
    public function testArticleProductColor()
    {
        $article = $this->find('article', 1);
        $articleProductColor = $this->find('product_color', 1);
		
		$this->assertEquals(
            $article->getArticleProduct()->getProductColor(),
            $articleProductColor
        );
    }
}
