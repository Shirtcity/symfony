<?php

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\ImageResolver;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ProductNameResolverTest.
 */
class ProductNameResolverTest extends WebTestCase
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
     * Test resolve image.
     */
    public function testResolveImage()
    {
        $product = $this->find('product', 1);
        $this->assertEquals(
            'product.jpg',
            $this
                ->get('elcodi.image_resolver.product')
                ->getValidImage($product)
                ->getName()
        );
    }
}
