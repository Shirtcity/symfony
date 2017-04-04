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
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;
use Elcodi\Component\Article\ImageResolver\Interfaces\ArticleImageResolverInterface;

/**
 * Class ArticleImageResolver.
 */
class ArticleImageResolver extends AbstractImageResolverWithImageResolver implements ArticleImageResolverInterface
{
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Article\Entity\Interfaces\ArticleInterface';
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
         * @var ArticleInterface $purchasable
         */
        return $this
            ->imageResolver
            ->resolveImage($purchasable);
    }
	
	/**
	 * Get article preview
	 * 
	 * @param ArticleInterface $article
	 */
	public function getPreviewImage(ArticleInterface $article) {
		return '123';
	}
}
