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

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Article\NameResolver\Interfaces\PurchasableNameResolverInterface;
use Elcodi\Component\Article\NameResolver\ArticleNameResolver;
use Elcodi\Component\Article\NameResolver\PurchasableNameResolver;
use Elcodi\Component\Article\NameResolver\VariantNameResolver;

/**
 * Class VariantNameResolverTest.
 */
class VariantNameResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveName(PurchasableNameResolverInterface $resolver)
    {
        $article = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');
        $variant = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\VariantInterface');
        $article
            ->getName()
            ->willReturn('Article Name');

        $variant
            ->getArticle()
            ->willReturn($article->reveal());

        $variant
            ->getName()
            ->willReturn(null);

        $attribute1 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');
        $attribute1->getName()->willReturn('attribute1');
        $value1 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface');
        $value1->getAttribute()->willReturn($attribute1->reveal());
        $value1->getValue()->willReturn('value1');

        $attribute2 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface');
        $attribute2->getName()->willReturn('attribute2');
        $value2 = $this->prophesize('Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface');
        $value2->getAttribute()->willReturn($attribute2->reveal());
        $value2->getValue()->willReturn('value2');

        $variant
            ->getOptions()
            ->willReturn(new ArrayCollection([
                $value1->reveal(),
                $value2->reveal(),
            ]));
        $variant = $variant->reveal();

        $this->assertEquals(
            'Article Name - attribute1 value1 - attribute2 value2',
            $resolver->resolveName(
                $variant
            )
        );

        $this->assertEquals(
            'Article Name # attribute1 value1 # attribute2 value2',
            $resolver->resolveName(
                $variant,
                ' # '
            )
        );
    }

    /**
     * Data for testResolveName.
     */
    public function dataResolveName()
    {
        $variantNameResolver = new VariantNameResolver();
        $purchasableNameResolver = new PurchasableNameResolver();
        $purchasableNameResolver->addPurchasableNameResolver($variantNameResolver);

        return [
            [$purchasableNameResolver],
            [$variantNameResolver],
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

    /**
     * Test resolve name.
     *
     * @dataProvider dataResolveName
     */
    public function testResolveNameWithName(PurchasableNameResolverInterface $resolver)
    {
        $variant = $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\VariantInterface');

        $variant
            ->getName()
            ->willReturn('Variant name');

        $variant = $variant->reveal();

        $this->assertEquals(
            'Variant name',
            $resolver->resolveName(
                $variant
            )
        );

        $this->assertEquals(
            'Variant name',
            $resolver->resolveName(
                $variant,
                ' # '
            )
        );
    }
}
