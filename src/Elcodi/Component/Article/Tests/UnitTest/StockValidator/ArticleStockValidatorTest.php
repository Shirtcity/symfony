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

namespace Elcodi\Component\Article\Tests\UnitTest\Validator;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Article\StockValidator\ArticleStockValidator;
use Elcodi\Component\Article\StockValidator\PurchasableStockValidator;

/**
 * Class ArticleStockValidatorTest.
 */
class ArticleStockValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test isStockAvailable() with a purchasable non article.
     */
    public function testIsValidNonArticle()
    {
        $articleValidator = new ArticleStockValidator();
        $this->assertFalse(
            $articleValidator->isStockAvailable(
                $this
                    ->prophesize('Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test isStockAvailable() with a purchasable non article.
     *
     * @dataProvider dataIsValidArticle
     */
    public function testIsValidArticle(
        $articleIsEnabled,
        $articleStock,
        $stockRequired,
        $useStock,
        $isValid
    ) {
        $article = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');
        $article
            ->isEnabled()
            ->willReturn($articleIsEnabled);
        $article
            ->getStock()
            ->willReturn($articleStock);
        $article = $article->reveal();

        $articleValidator = new ArticleStockValidator();
        $this->assertEquals(
            $isValid,
            $articleValidator->isStockAvailable(
                $article,
                $stockRequired,
                $useStock
            )
        );

        $purchasableValidator = new PurchasableStockValidator();
        $purchasableValidator->addPurchasableStockValidator($articleValidator);
        $this->assertEquals(
            $isValid,
            $purchasableValidator->isStockAvailable(
                $article,
                $stockRequired,
                $useStock
            )
        );
    }

    /**
     * data for testIsValidArticle.
     */
    public function dataIsValidArticle()
    {
        return [
            'Article disabled' => [false, 3, 2, true, false],
            'Available stock with stock usage' => [true, 3, 2, true, true],
            'Same stock elements than required' => [true, 3, 3, true, true],
            'Required more elements than stock' => [true, 2, 3, true, 2],
            'Article without stock' => [true, 0, 3, true, false],
            'Required 0 elements' => [true, 0, 0, true, false],
            'Required more elements that existent with no stock usage' => [true, 2, 3, false, true],
            'Required 0 elements with no stock usage' => [true, 0, 0, false, false],
        ];
    }
}
