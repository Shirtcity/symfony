<?php

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

use Elcodi\Component\Currency\Entity\Money;

/**
 * Class ProductTest
 */
class ProductTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ProductBundle',
        ];
    }

    /**
     * Test product colors
     */
    public function testProductColors()
    {
        $product = $this->find('product', 1);
        $productColor = $this->find('productColor', 1);
        
        $productColors = $product->getColors()[0];
        
		$this->assertEquals(
            $productColors->getColor(),
            $productColor
        );
    }
    
    /**
     * Test product sizes
     */
    public function testProductSizes()
    {
        $product = $this->find('product', 1);
        $productSize = $this->find('productSize', 1);
        
        $productSizes = $product->getSizes()[0];
        
		$this->assertEquals(
            $productSizes->getSize(),
            $productSize
        );
    }
    
    /**
     * Test product print method
     */
    public function testProductPrintMethod()
    {
        $product = $this->find('product', 1);
        $printMethod = $this->find('printMethod', 1);
        
        $productPrintMethod = $product->getPrintMethods()[0];
        
		$this->assertEquals(
            $productPrintMethod,
            $printMethod
        );
    }
    
    /**
     * Test product print side
     */
    public function testProductPrintSide()
    {
        $product = $this->find('product', 1);
        $printSide = $this->find('printSide', 1);
        
        $productPrintSide = $product->getPrintSides()[0];
        
		$this->assertEquals(
            $productPrintSide,
            $printSide
        );
    }
    
    /**
     * Test product empty variants
     */
    public function testProductEmptyVariants()
    {
        $product = $this->find('product', 1);
        
        $productColors = $product->getColors()[0];
        
        $this->assertTrue(
            $productColors
                ->getSizes()
                ->isEmpty()
        );
        
        $productSizes = $product->getSizes()[0];
        
        $this->assertTrue(
            $productSizes
                ->getColors()
                ->isEmpty()
        );
    }
    
    /**
     * Test product set variants
     */
    public function testProductSetVariants()
    {
        $product = $this->find('product', 1);
        
        $product->setVariants();
        $this->flush($product);
        
        $productSizes = $product->getSizes()[0];
        $productColors = $product->getColors()[0];
        
        $this->assertEquals(
            $productColors
                ->getSizes()
                ->contains($productSizes),
            true
        );
        
        $this->assertTrue(
            $productSizes
                ->getColors()
                ->contains($productColors)
        );      
    }
    
    /**
     * Test product get variants
     */
    public function testProductGetVariants()
    {
        $product = $this->find('product', 1);
        
        $variants = $product->getVariants();
        
        $productColor = $this->find('productColor', 1);
        $productSize = $this->find('productSize', 1);
        
        $this->assertTrue(
            $variants[$productSize->getId()][$productColor->getId()]
        );
    }
    
    /**
     * Test product get prices
     */
    public function testProductGetPrices()
    {
        $product = $this->find('product', 1);
        $prices = $product->getPrices();
        $price = $prices[0];
        
        $currencies = $this->findAll('currency');
        $dollarCurrency = $currencies[0];
        
        $money = Money::create(10, $dollarCurrency);        
        
        $this->assertEquals(
            $money,
            $price
        );
    }
}
