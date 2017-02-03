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

namespace Elcodi\Component\Article\Tests\UnitTest\ImageResolver\Abstracts;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Article\ImageResolver\ArticleImageResolver;
use Elcodi\Component\Article\ImageResolver\VariantImageResolver;

/**
 * Class AbstractImageResolverTest.
 */
abstract class AbstractImageResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get article image resolver mock.
     *
     * @param ImageInterface|false $image Image
     *
     * @return ArticleImageResolver
     */
    protected function getArticleImageMock($image)
    {
        $articleImageResolver = $this->prophesize('Elcodi\Component\Article\ImageResolver\ArticleImageResolver');
        $articleImageResolver
            ->getValidImage(Argument::any())
            ->willReturn($image);

        $articleImageResolver
            ->getPurchasableNamespace()
            ->willReturn('Elcodi\Component\Article\Entity\Interfaces\ArticleInterface');

        return $articleImageResolver->reveal();
    }

    /**
     * Get variant image resolver mock.
     *
     * @param ImageInterface|false $image Image
     *
     * @return VariantImageResolver
     */
    protected function getVariantImageMock($image)
    {
        $variantImageResolver = $this->prophesize('Elcodi\Component\Article\ImageResolver\VariantImageResolver');
        $variantImageResolver
            ->getValidImage(Argument::any())
            ->willReturn($image);

        $variantImageResolver
            ->getPurchasableNamespace()
            ->willReturn('Elcodi\Component\Article\Entity\Interfaces\VariantInterface');

        return $variantImageResolver->reveal();
    }
}
