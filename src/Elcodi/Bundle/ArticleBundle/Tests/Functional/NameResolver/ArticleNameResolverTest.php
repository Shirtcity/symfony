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

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\NameResolver;

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
     * Test resolve name.
     */
    public function testResolveName()
    {
        $article = $this->find('article', 2);
        $this->assertEquals(
            'Article with printables',
            $this
                ->get('elcodi.name_resolver.article')
                ->resolveName($article)
        );
        $this->assertEquals(
            'Article with printables',
            $this
                ->get('elcodi.name_resolver.purchasable')
                ->resolveName($article)
        );
    }
}
