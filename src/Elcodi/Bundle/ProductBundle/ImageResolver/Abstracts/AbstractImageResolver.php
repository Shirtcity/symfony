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

namespace Elcodi\Bundle\ProductBundle\ImageResolver\Abstracts;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\ImageResolver\ProductImageResolver;

/**
 * Class AbstractImageResolver.
 */
abstract class AbstractImageResolver
{
    /**
     * @var ProductImageResolverInterface[]
     *
     * Image resolvers
     */
    private $productImageResolvers = [];

    /**
     * Add an image resolver.
     *
     * @param ProductImageResolver $productImageResolver Product Image resolver
     */
    public function addProductImageResolver(ProductImageResolver $productImageResolver)
    {
        $this->productImageResolvers[] = $productImageResolver;
    }

    /**
     * Get valid Image.
     *
     * @param ProductInterface $product Product
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImageByCollection(Product $product)
    {
        foreach ($this->productImageResolvers as $productImageResolver) {
            $productImageResolverNamespace = $productImageResolver->getProductNamespace();
            if ($product instanceof $productImageResolverNamespace) {
                return $productImageResolver->getValidImage($product);
            }
        }

        return false;
    }
}
