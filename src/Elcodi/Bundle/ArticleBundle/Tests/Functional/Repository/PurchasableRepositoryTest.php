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

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Repository;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Bundle\CategoryBundle\Repository\CategoryRepository;
use Elcodi\Component\Article\Repository\PurchasableRepository;

/**
 * Class PurchasableRepositoryTest.
 */
class PurchasableRepositoryTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * LocationProvider class
     */
    protected $categoryRepository;

    /**
     * @var PurchasableRepository
     *
     * LocationProvider class
     */
    protected $purchasableRepository;

    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
			'ProductBundle',
            'ElcodiArticleBundle',			
        ];
    }

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->purchasableRepository = $this->get('elcodi.repository.purchasable');
        $this->categoryRepository = $this->get('elcodi.repository.category');
    }

    /**
     * Test purchasable repository provider.
     */
    public function testRepositoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.purchasable')
        );
    }

    /**
     * Test get home purchasables.
     *
     * @dataProvider dataGetHomePurchasables
     */
    public function testGetHomePurchasables($count, $numberExpected)
    {
        $purchasable = $this->find('purchasable', 2);
		
        $purchasables = $this
            ->purchasableRepository
            ->getHomePurchasables($count);

        $this->assertTrue(is_array($purchasables));
        $this->assertCount($numberExpected, $purchasables);
    }

    /**
     * Count values for testGetHomePurchasables.
     */
    public function dataGetHomePurchasables()
    {
        return [
            [0, 3],
            [1, 1],
            [2, 2],
			[3, 3],
            [7, 3],
        ];
    }

}
