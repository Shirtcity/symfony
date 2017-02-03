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

namespace Elcodi\Component\Article\Adapter\SimilarPurchasablesProvider\Interfaces;

use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;

/**
 * Interface RelatedPurchasablesProviderInterface.
 */
interface RelatedPurchasablesProviderInterface
{
    /**
     * Given a Purchasable, return a collection of related purchasables.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param int                  $limit       Limit of elements retrieved
     *
     * @return array Related articles
     */
    public function getRelatedPurchasables(PurchasableInterface $purchasable, $limit);

    /**
     * Given a Collection of Purchasables, return a collection of related
     * purchasables.
     *
     * @param PurchasableInterface[] $purchasables Purchasable
     * @param int                    $limit        Limit of elements retrieved
     *
     * @return array Related articles
     */
    public function getRelatedPurchasablesFromArray(array $purchasables, $limit);
}
