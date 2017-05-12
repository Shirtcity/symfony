<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticleProductPrintSideTest
 */
class ArticleProductPrintSideTest extends WebTestCase
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
     * Test article product print sides
     */
    public function testArticleProductPrintSides()
    {
        $article = $this->find('article', 2);
        $articleProduct = $this->find('article_product', 2);
		$articleProductPrintSide = $this->find('article_product_print_side', 1);
		
		$this->assertEquals(
            $article->getArticleProduct(),
            $articleProduct
        );
		
		$this->assertEquals(
            $article->getArticleProduct()->getArticleProductPrintSides()->first(),
            $articleProductPrintSide
        );
    }
	
	/**
     * Test article product print side printable variants
     */
    public function testArticleProductPrintSidePrintableVariants()
    {
        $article = $this->find('article', 2);
		$articleProductPrintSidePrintables = $article
			->getArticleProduct()
			->getArticleProductPrintSides()
			->first()
			->getPrintableVariants();
		
		$printableVariantText = $this->find('printable_variant', 1);
		$printableVariantDesign = $this->find('printable_variant', 2);		
		
		$this->assertEquals(
            $articleProductPrintSidePrintables->first(),
            $printableVariantText
        );
		
		$this->assertEquals(
            $articleProductPrintSidePrintables->first()->getText()->getContent(),
            'El bufalo de la noche sueña con nosotros'
        );
		
		$this->assertEquals(
            $articleProductPrintSidePrintables->last(),
            $printableVariantDesign
        );	
		
		$this->assertEquals(
            $articleProductPrintSidePrintables->last()->getDesign()->getName(),
            'Design'
        );	
    }
}

