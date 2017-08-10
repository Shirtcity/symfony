<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticlePrintableVariantAdapterTestAbstract.
 */
abstract class ArticlePrintableVariantAdapterTestAbstract extends WebTestCase
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
     * Test article printable variant position adapter.
     *
     * @dataProvider dataAdapter
     */
    public function testAdapter($positionName, $positionValue, $expectedPosistionValue) 
    {   
        $setter = 'set' . $positionName;
        $getter = 'get' . $positionName;
        
        $validator = $this->get('validator');        
        $article = $this->find('article', 2);
        
        $articleProductPrintSide = $article
            ->getArticleProduct()
            ->getArticleProductPrintSides()
            ->first();
        
        $printableVariant = $articleProductPrintSide
            ->getPrintableVariants()
            ->first();        

        
        $printableVariant->$setter($positionValue);
 
        $validator->validate($article);
   
        $this->assertEquals(            
            $expectedPosistionValue,
            $printableVariant->$getter()
        );        
    }
    
    /**
     * Data for testAdapter.
     */
    abstract function dataAdapter();
}
