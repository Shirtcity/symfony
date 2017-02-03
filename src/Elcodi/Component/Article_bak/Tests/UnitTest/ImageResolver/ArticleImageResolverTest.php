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

namespace Elcodi\Component\Article\Tests\UnitTest\ImageResolver;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Article\ImageResolver\ArticleImageResolver;
use Elcodi\Component\Article\ImageResolver\PurchasableImageResolver;

/**
 * Class ArticleImageResolverTest.
 */
class ArticleImageResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $implementsArticle,
        $imageResolverResult,
        $result
    ) {
        $purchasable = $implementsArticle
            ? $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface')
            : $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface');
        $purchasable = $purchasable->reveal();

        $imageResolver = $this->prophesize('Elcodi\Component\Media\Services\ImageResolver');
        $imageResolver->resolveImage($purchasable)->willReturn($imageResolverResult);
        $articleImageResolver = new ArticleImageResolver($imageResolver->reveal());
        $this->assertSame(
            $result,
            $articleImageResolver->getValidImage(
                $purchasable
            )
        );

        $purchasableImageResolver = new PurchasableImageResolver();
        $purchasableImageResolver->addPurchasableImageResolver($articleImageResolver);
        $this->assertSame(
            $result,
            $purchasableImageResolver->getValidImage(
                $purchasable
            )
        );
    }

    /**
     * Data for testResolveImage.
     */
    public function dataResolveImage()
    {
        $image = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\MediaInterface')
            ->reveal();

        return [
            'non article' => [false, false, false],
            'article, image not found' => [true, false, false],
            'article, image found' => [true, $image, $image],
        ];
    }
}
