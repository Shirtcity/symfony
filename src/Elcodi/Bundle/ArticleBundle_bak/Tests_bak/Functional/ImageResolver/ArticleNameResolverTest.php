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

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\ImageResolver;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ArticleNameResolverTest.
 */
class ArticleNameResolverTest extends WebTestCase
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
     * Test resolve image.
     */
    public function testResolveImage()
    {
        $article = $this->find('article', 2);
        $this->assertEquals(
            'article.jpg',
            $this
                ->get('elcodi.image_resolver.purchasable')
                ->getValidImage($article)
                ->getName()
        );
    }

    /**
     * Test resolve image.
     */
    public function testResolveImageEmpty()
    {
        $article = $this->find('article', 1);
        $this->assertFalse(
            $this
                ->get('elcodi.image_resolver.purchasable')
                ->getValidImage($article)
        );
    }
}
