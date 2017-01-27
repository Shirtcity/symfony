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

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Article\ElcodiArticleStock;
use Elcodi\Component\Article\StockUpdater\ArticleStockUpdater;
use Elcodi\Component\Article\StockUpdater\PurchasableStockUpdater;

/**
 * Class ArticleStockUpdaterTest.
 */
class ArticleStockUpdaterTest extends PHPUnit_Framework_TestCase
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
    }

    /**
     * Test update stock.
     *
     * @dataProvider dataUpdateStock
     */
    public function testUpdateStock(
        $actualStock,
        $stockToDecrease,
        $newStock,
        $flush,
        $result
    ) {
        $article = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');
        $article
            ->getStock()
            ->willReturn($actualStock);
        if (!is_null($newStock)) {
            $article->setStock($newStock)->shouldBeCalled();
        }
        $article = $article->reveal();

        $objectManager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        if ($flush) {
            $objectManager->flush(Argument::any());
        }

        $articleStockUpdater = new ArticleStockUpdater($objectManager->reveal());
        $this->assertEquals(
            $result,
            $articleStockUpdater->updateStock(
                $article,
                $stockToDecrease
            )
        );

        $purchasableStockUpdater = new PurchasableStockUpdater();
        $purchasableStockUpdater->addPurchasableStockUpdater($articleStockUpdater);
        $this->assertEquals(
            $result,
            $purchasableStockUpdater->updateStock(
                $article,
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

        return [
            'All ok' => [3, 1, 2, true, 1],
            'infinite stock' => [$infStock, 1, null, false, false],
            'We decrease more than existing elements' => [2, 3, 0, true, 2],
        ];
    }
}
