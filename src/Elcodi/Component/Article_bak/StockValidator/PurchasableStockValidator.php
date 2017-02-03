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

namespace Elcodi\Component\Article\StockValidator;

use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\StockValidator\Interfaces\PurchasableStockValidatorInterface;
use Elcodi\Component\Article\StockValidator\Traits\PurchasableStockValidatorCollectorTrait;

/**
 * Class PurchasableValidator.
 */
class PurchasableStockValidator implements PurchasableStockValidatorInterface
{
    use PurchasableStockValidatorCollectorTrait;

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return null;
    }

    /**
     * Update stock.
     *
     * @param PurchasableInterface $purchasable     Purchasable
     * @param int                  $stockToDecrease Stock to decrease
     * @param bool                 $useStock        Use stock
     *
     * @return bool|int Is valid or the number of elements that can be used
     */
    public function isStockAvailable(
        PurchasableInterface $purchasable,
        $stockToDecrease,
        $useStock
    ) {
        return $this->isValidByLoadedValidators(
            $purchasable,
            $stockToDecrease,
            $useStock
        );
    }
}
