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

namespace Elcodi\Component\Article\Tests\UnitTest\StockUpdater;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Article\ElcodiArticleStock;
use Elcodi\Component\Article\StockUpdater\PackStockUpdater;
use Elcodi\Component\Article\StockUpdater\ArticleStockUpdater;
use Elcodi\Component\Article\StockUpdater\VariantStockUpdater;

/**
 * Class PackStockUpdaterTest.
 */
class PackStockUpdaterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test update stock with a no article.
     */
    public function testUpdateStockNoArticle()
    {
        $objectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        $articleStockUpdater = new ArticleStockUpdater($objectManager->reveal());
        $this->assertFalse(
            $articleStockUpdater->updateStock(
                $this
                    ->prophesize('Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface')
                    ->reveal(),
                0,
                false
            )
        );

        $this->assertFalse(
            $articleStockUpdater->updateStock(
                $this
                    ->prophesize('Elcodi\Component\Article\Entity\Interfaces\VariantInterface')
                    ->reveal(),
                0,
                false
            )
        );
    }

    /**
     * Test update stock.
     *
     * @dataProvider dataUpdateStock
     */
    public function testUpdateStock(
        $stockToDecrease,
        $packStockType,
        $packStock,
        $packNewStock,
        $packFlush,
        $articleStock,
        $articleNewStock,
        $articleFlush,
        $variantStock,
        $variantNewStock,
        $variantFlush,
        $result
    ) {
        $article = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');
        $article
            ->getStock()
            ->willReturn($articleStock);
        if (!is_null($articleNewStock)) {
            $article->setStock($articleNewStock)->shouldBeCalled();
        }
        $article = $article->reveal();
        $articleObjectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        if ($articleFlush) {
            $articleObjectManager
                ->flush(Argument::any())
                ->shouldBeCalled();
        }

        $variant = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\VariantInterface');
        $variant
            ->getStock()
            ->willReturn($variantStock);
        if (!is_null($variantNewStock)) {
            $variant->setStock($variantNewStock)->shouldBeCalled();
        }
        $variant = $variant->reveal();
        $variantObjectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        if ($variantFlush) {
            $variantObjectManager
                ->flush(Argument::any())
                ->shouldBeCalled();
        }

        $pack = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\PackInterface');
        $pack
            ->getStockType()
            ->willReturn($packStockType);
        $pack
            ->getStock()
            ->willReturn($packStock);
        $pack
            ->getPurchasables()
            ->willReturn(new ArrayCollection([
                $article,
                $variant,
            ]));
        if (!is_null($packNewStock)) {
            $pack->setStock($packNewStock)->shouldBeCalled();
        }
        $pack = $pack->reveal();
        $packObjectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        if ($packFlush) {
            $packObjectManager
                ->flush(Argument::any())
                ->shouldBeCalled();
        }

        $articleStockUpdater = new ArticleStockUpdater($articleObjectManager->reveal());
        $variantStockUpdater = new VariantStockUpdater($variantObjectManager->reveal());
        $packStockUpdater = new PackStockUpdater($packObjectManager->reveal());
        $packStockUpdater->addPurchasableStockUpdater($articleStockUpdater);
        $packStockUpdater->addPurchasableStockUpdater($variantStockUpdater);
        $this->assertEquals(
            $result,
            $packStockUpdater->updateStock(
                $pack,
                $stockToDecrease
            )
        );
    }

    /**
     * Data for testUpdateStock.
     */
    public function dataUpdateStock()
    {
        $infStock = ElcodiArticleStock::INFINITE_STOCK;
        $inhStock = ElcodiArticleStock::INHERIT_STOCK;
        $spcStock = ElcodiArticleStock::SPECIFIC_STOCK;

        return [
            // Without inheritance stock
            'Without inh: All ok' => [1, $spcStock, 2, 1, true, null, null, false, null, null, false, 1],
            'Without inh: We decrease more than existing elements' => [2, $spcStock, 1, 0, true, null, null, false, null, null, false, 1],
            'Without inh: We decrease 0' => [0, $spcStock, 2, null, false, null, null, false, null, null, false, false],
            'Without inh: Negative stock' => [2, $spcStock, -2, null, false, null, null, false, null, null, false, false],
            'Without inh: 0 stock' => [2, $spcStock, 0, null, false, null, null, false, null, null, false, false],

            // With inheritance stock
            'Inh: All ok' => [1, $inhStock, null, null, false, 2, 1, true, 3, 2, true, 1],
            'Inh: One with less stock than needed' => [2, $inhStock, null, null, false, 1, 0, true, 3, 1, true, false],
            'Inh: One with infinite stock' => [2, $inhStock, null, null, false, $infStock, null, true, 3, 1, true, false],
            'Inh: One with 0 stock' => [2, $inhStock, null, null, false, 0, null, true, 3, 1, true, false],
            'Inh: One with negative stock' => [2, $inhStock, null, null, false, -2, null, true, 3, 1, true, false],
        ];
    }
}
