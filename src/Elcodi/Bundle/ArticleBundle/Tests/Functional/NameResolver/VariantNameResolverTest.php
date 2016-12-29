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
 * Class VariantNameResolverTest.
 */
class VariantNameResolverTest extends WebTestCase
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
        $variant = $this->find('article_variant', 6);
        $this->assertEquals(
            'Article with variants - Size Large - Color White',
            $this
                ->get('elcodi.name_resolver.article_variant')
                ->resolveName($variant)
        );
        $this->assertEquals(
            'Article with variants - Size Large - Color White',
            $this
                ->get('elcodi.name_resolver.purchasable')
                ->resolveName($variant)
        );
    }
}
