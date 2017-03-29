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

namespace Elcodi\Component\Article\Tests\UnitTest\NameResolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Article\NameResolver\Interfaces\PurchasableNameResolverInterface;
use Elcodi\Component\Article\NameResolver\ArticleNameResolver;
use Elcodi\Component\Article\NameResolver\PurchasableNameResolver;

/**
 * Class ArticleNameResolverTest.
 */
class ArticleNameResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveName(PurchasableNameResolverInterface $resolver)
    {
        $article = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');
        $article
            ->getName()
            ->willReturn('My Article');

        $this->assertEquals(
            'My Article',
            $resolver->resolveName(
                $article->reveal()
            )
        );
    }

    /**
     * Data for testResolveName.
     */
    public function dataResolveName()
    {
        $articleNameResolver = new ArticleNameResolver();
        $purchasableNameResolver = new PurchasableNameResolver();
        $purchasableNameResolver->addPurchasableNameResolver($articleNameResolver);

        return [
            [$purchasableNameResolver],
            [$articleNameResolver],
        ];
    }

    /**
     * Test resolve name with bad purchasable instance.
     */
    public function testResolveNameBadInstance()
    {
        $purchasable = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface');
        $articleNameResolver = new ArticleNameResolver();
        $this->assertFalse(
            $articleNameResolver->resolveName(
                $purchasable->reveal()
            )
        );
    }
}
