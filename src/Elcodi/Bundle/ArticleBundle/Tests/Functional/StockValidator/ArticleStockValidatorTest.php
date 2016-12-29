<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\StockValidator;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticleStockValidatorTest.
 */
class ArticleStockValidatorTest extends WebTestCase
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
     * Test article validator.
     */
    public function testIsStockAvailable()
    {
        $article = $this->find('article', 1);
        $articleStockValidator = $this->get('elcodi.stock_validator.article');
        $this->assertTrue(
            $articleStockValidator->isStockAvailable(
                $article,
                1,
                true
            )
        );

        $this->assertEquals(
            10,
            $articleStockValidator->isStockAvailable(
                $article,
                11,
                true
            )
        );

        $purchasableStockValidator = $this->get('elcodi.stock_validator.purchasable');

        $this->assertTrue(
            $purchasableStockValidator->isStockAvailable(
                $article,
                1,
                true
            )
        );

        $this->assertEquals(
            10,
            $purchasableStockValidator->isStockAvailable(
                $article,
                11,
                true
            )
        );
    }
}
