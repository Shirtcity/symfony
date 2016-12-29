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

namespace Elcodi\Component\Article\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

use Elcodi\Component\Article\Services\ArticleOptionsResolver;

/**
 * Class ArticleOptionsResolverExtension.
 */
final class ArticleOptionsResolverExtension extends Twig_Extension
{
    /**
     * @var ArticleOptionsResolver
     *
     * Article options resolver
     */
    private $articleOptionsResolver;

    /**
     * Construct.
     *
     * @param ArticleOptionsResolver $articleOptionsResolver Article options resolver
     */
    public function __construct(ArticleOptionsResolver $articleOptionsResolver)
    {
        $this->articleOptionsResolver = $articleOptionsResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFunction[] Functions
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('available_options', [
                $this->articleOptionsResolver,
                'getAvailableOptions',
            ]),
        ];
    }

    /**
     * return extension name.
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'article_options_resolver_extension';
    }
}
