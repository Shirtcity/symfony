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

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\StockUpdater;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticleStockUpdaterTest.
 */
class ArticleStockUpdaterTest extends WebTestCase
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
     * Test update stock.
     */
    public function testUpdateStock()
    {
        $article = $this->find('article', 1);
        $this->get('elcodi.stock_updater.article')->updateStock(
            $article,
            2
        );
        $this->clear($article);
        $article = $this->find('article', 1);
        $this->assertEquals(
            8,
            $article->getStock()
        );
    }
}
