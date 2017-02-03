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
use Elcodi\Component\Article\ElcodiArticleStock;
use Elcodi\Component\Article\ElcodiArticleTypes;
use Elcodi\Component\Article\Entity\Article;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;
use Elcodi\Component\Article\Factory\ArticleProductFactory;

/**
 * Factory for Article entities.
 */
class ArticleFactory extends AbstractPurchasableFactory
{
    /**
     * @var bool
     *
     * Use use stock
     */
    public $useStock = false;
	
    /**
     * Set use stock.
     *
     * @param bool $useStock Infinite stock
     *
     * @return $this Self object
     */
    public function setUseStock($useStock = false)
    {
        $this->useStock = $useStock;

        return $this;
    }

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

        /**
         * @var Article $article
         */
        $classNamespace = $this->getEntityNamespace();
        $article = new $classNamespace();

        $stock = $this->useStock
            ? 0
            : ElcodiArticleStock::INFINITE_STOCK;

        $article
            ->setStock($stock)
            ->setType(ElcodiArticleTypes::TYPE_PRODUCT_PHYSICAL)
            ->setShowInHome(true)
            ->setPrice($zeroPrice)
            ->setReducedPrice($zeroPrice)
            ->setAttributes(new ArrayCollection())
            ->setCategories(new ArrayCollection())
            ->setImages(new ArrayCollection())
            ->setWidth(0)
            ->setHeight(0)
            ->setDepth(0)
            ->setWidth(0)
            ->setWeight(0)
            ->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $article;
    }
}
