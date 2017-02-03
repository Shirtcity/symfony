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

namespace Elcodi\Bundle\ProductBundle\ImageResolver;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;

/**
 * Class ProductImageResolver.
 */
class ProductImageResolver extends AbstractImageResolverWithImageResolver
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getProductNamespace()
    {
        return 'Elcodi\Bundle\ProductBundle\Entity\Product';
    }

    /**
     * Get valid Image.
     *
     * @param Product $product Product
     *
     * @todo typecast to product failed. It gets an product instead.
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImage($product)
    {
        $namespace = $this->getProductNamespace();
        if (!$product instanceof $namespace) {
            return false;
        }

        /**
         * @var ProductInterface $product
         */
        return $this
            ->imageResolver
            ->resolveImage($product);
    }
}
