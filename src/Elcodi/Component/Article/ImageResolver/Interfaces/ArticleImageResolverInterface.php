<?php

namespace Elcodi\Component\Article\ImageResolver\Interfaces;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\ImageResolver\Interfaces\PurchasableImageResolverInterface;

/**
 * Interface ArticleImageResolverInterface.
 */
interface ArticleImageResolverInterface extends PurchasableImageResolverInterface
{

    /**
     * Get valid Image.
     *
     * @param ArticleInterface $article Article
     *
     * @return ImageInterface|false Image resolved
     */
    public function getPreviewImage(ArticleInterface $article);
}
