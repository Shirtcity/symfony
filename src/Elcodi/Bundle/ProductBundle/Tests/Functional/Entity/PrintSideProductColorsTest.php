<?php

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class PrintSideProductColorsTest
 */
class PrintSideProductColorsTest extends WebTestCase
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
     * Test print side product colors product colors
     */
    public function testPrintSideProductColorsProductColors()
    {
        $printSideProductColors = $this->find('printSideProductColors', 1);
        $productColors = $this->find('productColors', 1);
        
		$this->assertEquals(
            $productColors,
            $printSideProductColors->getProductColors()
        );
    }
    
    /**
     * Test print side product colors image name
     */
    public function testPrintSideProductColorsImageName()
    {
        $printSideProductColors = $this->find('printSideProductColors', 1);
        
		$this->assertEquals(
            'print-side.png',
            $printSideProductColors
                ->getImage()
                ->getName()
        );
    }
}
