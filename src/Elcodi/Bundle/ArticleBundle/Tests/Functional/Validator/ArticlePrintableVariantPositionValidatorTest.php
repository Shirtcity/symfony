<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class SameCategoryRelatedPurchasablesProviderTest.
 */
class ArticlePrintableVariantPositionValidatorTest extends WebTestCase
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
     * @dataProvider dataValidator
     */
    public function testValidator(
        $posX,
        $posY,
        $width,
        $height,
        $errorsCount
    ) {
        
        $validator = $this->get('validator');
        
        $article = $this->find('article', 2);
        
        $articleProductPrintSide = $article
            ->getArticleProduct()
            ->getArticleProductPrintSides()
            ->first();
        
        $printableVariants = $articleProductPrintSide->getPrintableVariants();        

        foreach ($printableVariants as $printableVariant) {
            $printableVariant
                ->setPosX($posX)
                ->setPosY($posY)
                ->setWidth($width)
                ->setHeight($height);
        }        
        
        $errors = $validator->validate($article);
        
        /*foreach ($errors as $key => $error) {
            print_r($error->getMessage());
        }*/
        
        //print_r(count($errors));
        $this->assertEquals($errorsCount, count($errors));        
    }
    
    /**
     * Data for testValidator.
     */
    public function dataValidator()
    {
        return [
            'printable suits to print area'         => [160, 120, 50, 50, 0],
            'printable doesnt suit to position X'	=> [800, 120, 50, 50, 2],
            'printable doesnt suit to position Y'	=> [160, 800, 50, 50, 2],
            'printable doesnt suit by width'        => [160, 120, 800, 50, 2],
            'printable doesnt suit by height'       => [160, 120, 50, 800, 2],
            'printable doesnt suit completely'      => [800, 800, 800, 500, 2],
            
            'printable posX = print area posX'      => [155, 120, 50, 50, 0],
            'printable posY = print area posY'      => [160, 100, 50, 50, 0],
            
            'printable fills print area by width'   => [155, 120, 200, 50, 0],
            'printable fills print area by height'  => [160, 100, 20, 300, 0],
        ];
    }
}
