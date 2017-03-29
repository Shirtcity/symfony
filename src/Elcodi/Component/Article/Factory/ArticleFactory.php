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

namespace Elcodi\Component\Article\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;
use Elcodi\Component\Article\ElcodiArticleTypes;
use Elcodi\Component\Article\Entity\Article;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;
use Elcodi\Component\Article\Entity\ArticleProduct;

/**
 * Factory for Article entities.
 */
class ArticleFactory extends AbstractPurchasableFactory
{    
    
    /**
     * Creates and returns a pristine Article instance.
     *
     * Prices are initialized to "zero amount" Money value objects,
     * using injected CurrencyWrapper default Currency
     *
     * @return Article New Article entity
     */
    public function create()
    {
        $zeroPrice = $this->createZeroAmountMoney();
		$articleProduct = new ArticleProduct();
		$articleProduct
            ->setProduct()
            ->setProductColor();
		
        /**
         * @var Article $article
         */
        $classNamespace = $this->getEntityNamespace();
		
        $article = new $classNamespace();

        $article
            ->setType(ElcodiArticleTypes::TYPE_PRODUCT_PHYSICAL)
            ->setShowInHome(true)
            ->setAttributes(new ArrayCollection())
            ->setCategories(new ArrayCollection())
            ->setImages(new ArrayCollection())
            ->setImagesSort('')
            ->setEnabled(true)
			->setArticleProduct($articleProduct)
            ->setCreatedAt($this->now());

        return $article;
    }
}
