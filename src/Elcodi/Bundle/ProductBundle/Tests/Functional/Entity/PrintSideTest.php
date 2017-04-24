<?php

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class PrintSideTest
 */
class PrintSideTest extends WebTestCase
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
     * Test print side area
     */
    public function testPrintSideArea()
    {
        $printSide = $this->find('printSide', 1);
        $printSideArea = $this->find('printSideArea', 1);
        
		$this->assertTrue(
            $printSide
                ->getAreas()
                ->contains($printSideArea)
        );
    }
    
    /**
     * Test print side type
     */
    public function testPrintSideType()
    {
        $printSide = $this->find('printSide', 1);
        $printSideType = $this->find('printSideType', 1);
        
		$this->assertEquals(
            $printSide->getType(),
            $printSideType
        );
    }
    
    /**
     * Test print side image
     */
    public function testPrintSideImage()
    {
        $printSide = $this->find('printSide', 1);
        
		$this->assertEquals(
            'print-side.png',
            $printSide
                ->getImage()
                ->getName()
        );
    }
    
    /**
     * Test print side product colors
     */
    public function testPrintSideProductColors()
    {
        $productColors = $this->find('productColors', 1);
        $printSideProductColors = $this->find('printSideProductColors', 1);
        
		$this->assertEquals(
            $printSideProductColors->getProductColors(),
            $productColors
        );
    }
}
