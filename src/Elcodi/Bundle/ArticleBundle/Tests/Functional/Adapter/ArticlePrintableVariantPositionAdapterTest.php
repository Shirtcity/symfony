<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter;

use Symfony\Component\Validator\Validation;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Article\Adapter\ArticlePrintableVariantPositionAdapter;
use Elcodi\Component\Article\Adapter\ArticlePrintableVariantSizeAdapter;
use Elcodi\Component\Article\Validator\ArticlePrintableVariantPositionValidator;
use Elcodi\Component\Article\Validator\Constraint\ArticleConstraint;


/**
 * Class SameCategoryRelatedPurchasablesProviderTest.
 */
class ArticlePrintableVariantPositionAdapterTest extends WebTestCase
{
    private $constraint;
    private $context;
    
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
    
    public function setUp()
    {
        $this->constraint = new ArticleConstraint();
        $this->context = $this
            ->getMockBuilder('Symfony\Component\Validator\ExecutionContext')
            ->disableOriginalConstructor()
            ->getMock();
    }

    
    public function testValidator(
        $posX,
        $posY,
        $width,
        $height,
        $errorsCount
    ) {
        $validator = Validation::createValidatorBuilder()
            ->addYamlMapping('/srv/www/shirtcity.dev2/src/Elcodi/Bundle/ArticleBundle/Resources/config/validators.yml')
            //->enableAnnotationMapping()
            ->getValidator();
        
        $articlePrintableVariantPositionAdapter = $this
                ->prophesize('Elcodi\Component\Article\Adapter\ArticlePrintableVariantPositionAdapter');
        
        $articlePrintableVariantSizeAdapter = $this
                ->prophesize('Elcodi\Component\Article\Adapter\ArticlePrintableVariantSizeAdapter');
        
      //  $validator = new ArticlePrintableVariantPositionValidator($articlePrintableVariantPositionAdapter, $articlePrintableVariantSizeAdapter);
        
        $validator = $this
            ->getMockBuilder('Elcodi\Component\Article\Validator\ArticlePrintableVariantPositionValidator')
            ->disableOriginalConstructor(true)
            ->getMock();
        
        $validator->initialize($this->context);

        /*$this->context
            ->expects($this->once())
            ->method('addViolation')
            ->with($this->constraint->message,array());*/
        
        //$validator->validate(\Datetime::createFromFormat("d/m/Y","10/10/2000"), $this->constraint);
    
        
        
        $article = $this->find('article', 2);
        $articleProductPrintSide = $article
            ->getArticleProduct()
            ->getArticleProductPrintSides()
            ->first();
        
        $printableVariantDesign = $articleProductPrintSide
            ->getDesignPrintableVariants()
            ->first();       
        

        // valid data test
        $printableVariantDesign
			->setPosX($posX)
			->setPosY($posY)
            ->setWidth($width)
            ->setHeight($height);
        
        $errors = $validator->validate($article, $this->constraint);
        $this->assertEquals($errorsCount, count($errors));        
    }
    
    /**
     * Data for testValidator.
     */
    public function dataValidator()
    {
        return [
            'printable suits to print area of an article'       => [15, 15, 20, 20, 0],
            'printable doesnt suit to print area of an article'	=> [800, 800, 800, 500, 10],
        ];
    }
}
