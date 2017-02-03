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

namespace Elcodi\Component\Article\ImageResolver;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\Entity\Interfaces\VariantInterface;
use Elcodi\Component\Article\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;
use Elcodi\Component\Article\ImageResolver\Interfaces\PurchasableImageResolverInterface;

/**
 * Class VariantImageResolver.
 */
class VariantImageResolver extends AbstractImageResolverWithImageResolver implements PurchasableImageResolverInterface
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Article\Entity\Interfaces\VariantInterface';
    }

    /**
     * Get valid Image.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImage(PurchasableInterface $purchasable)
    {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        /**
         * @var VariantInterface $purchasable
         */
        $variantImage = $this
            ->imageResolver
            ->resolveImage($purchasable);

        return $variantImage instanceof ImageInterface
            ? $variantImage
            : $this->getValidImageByCollection($purchasable->getArticle());
    }
}
