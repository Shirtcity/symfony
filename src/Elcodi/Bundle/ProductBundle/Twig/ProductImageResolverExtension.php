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

namespace Elcodi\Bundle\ProductBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Bundle\ProductBundle\ImageResolver\ProductImageResolver;

/**
 * Class ProductImageResolverExtension.
 */
final class ProductImageResolverExtension extends Twig_Extension
{
    /**
     * @var ProductImageResolverInterface
     *
     * Product image resolver
     */
    private $productImageResolver;

    /**
     * Construct.
     *
     * @param ProductImageResolver $productImageResolver Product image resolver
     */
    public function __construct(ProductImageResolver $productImageResolver)
    {
        $this->productImageResolver = $productImageResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('valid_image', [
                $this->productImageResolver,
                'getValidImage',
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
        return 'product_image_resolver_extension';
    }
}
