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

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Article\ImageResolver\PackImageResolver;
use Elcodi\Component\Article\ImageResolver\PurchasableImageResolver;
use Elcodi\Component\Article\Tests\UnitTest\ImageResolver\Abstracts\AbstractImageResolverTest;

/**
 * Class PackImageResolverTest.
 */
class PackImageResolverTest extends AbstractImageResolverTest
{
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $implementsPack,
        $imagePackResolverResult,
        $imageArticleResolverResult,
        $imageVariantResolverResult,
        $result
    ) {
        $purchasable = $implementsPack
            ? $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\PackInterface')
            : $this->prophesize('Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface');

        $articleImageResolver = $this->getArticleImageMock($imageArticleResolverResult);
        $variantImageResolver = $this->getVariantImageMock($imageVariantResolverResult);

        if ($implementsPack) {
            $purchasable
                ->getPurchasables()
                ->willReturn(
                    new ArrayCollection([
                        $this
                            ->prophesize('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface')
                            ->reveal(),
                        $this
                            ->prophesize('Elcodi\Component\Article\Entity\Interfaces\VariantInterface')
                            ->reveal(),
                    ])
                );
        }
        $purchasable = $purchasable->reveal();

        $imageResolver = $this->prophesize('Elcodi\Component\Media\Services\ImageResolver');
        $imageResolver
            ->resolveImage($purchasable)
            ->willReturn($imagePackResolverResult);

        $packImageResolver = new PackImageResolver($imageResolver->reveal());
        $packImageResolver->addPurchasableImageResolver($articleImageResolver);
        $packImageResolver->addPurchasableImageResolver($variantImageResolver);
        $this->assertSame(
            $result,
            $packImageResolver->getValidImage(
                $purchasable
            )
        );

        $purchasableImageResolver = new PurchasableImageResolver();
        $purchasableImageResolver->addPurchasableImageResolver($variantImageResolver);
        $purchasableImageResolver->addPurchasableImageResolver($articleImageResolver);
        $purchasableImageResolver->addPurchasableImageResolver($packImageResolver);
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
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        $anotherImage = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        $yetAnotherImage = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();

        return [
            'non pack' => [false, false, false, false, false],
            'pack, image not found, variant without images, article without images' => [true, false, false, false, false],
            'pack, image not found, variant without images, article with images' => [true, false, $image, false, $image],
            'pack, image found, variant without images, article without images' => [true, $image, false, false, $image],
            'pack, image found, variant without images, article with images' => [true, $image, $anotherImage, false, $image],
            'pack, image not found, variant with images, article without images' => [true, false, false, $yetAnotherImage, $yetAnotherImage],
            'pack, image not found, variant with images, article with images' => [true, false, $image, $yetAnotherImage, $image],
            'pack, image found, variant with images, article without images' => [true, $image, false, $yetAnotherImage, $image],
            'pack, image found, variant with images, article with images' => [true, $image, $anotherImage, $yetAnotherImage, $image],
        ];
    }
}
