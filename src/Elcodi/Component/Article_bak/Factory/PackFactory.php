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
use Elcodi\Component\Article\Entity\Pack;
use Elcodi\Component\Article\Entity\Article;

/**
 * Factory for Pack entities.
 */
class PackFactory extends AbstractPurchasableFactory
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

        /**
         * @var Pack $article
         */
        $classNamespace = $this->getEntityNamespace();
        $pack = new $classNamespace();

        $pack
            ->setStock(0)
            ->setType(ElcodiArticleTypes::TYPE_PRODUCT_PHYSICAL)
            ->setShowInHome(true)
            ->setPrice($zeroPrice)
            ->setReducedPrice($zeroPrice)
            ->setPurchasables(new ArrayCollection())
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

        return $pack;
    }
}
