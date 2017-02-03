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

use Elcodi\Component\Article\ElcodiArticleStock;
use Elcodi\Component\Article\Entity\Interfaces\PackInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\StockValidator\Interfaces\PurchasableStockValidatorInterface;
use Elcodi\Component\Article\StockValidator\Traits\PurchasableStockValidatorCollectorTrait;
use Elcodi\Component\Article\StockValidator\Traits\SimplePurchasableStockValidatorTrait;

/**
 * Class PackStockValidator.
 */
class PackStockValidator implements PurchasableStockValidatorInterface
{
    use PurchasableStockValidatorCollectorTrait,
        SimplePurchasableStockValidatorTrait;

    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Article\Entity\Interfaces\PackInterface';
    }

    /**
     * Gets purchasable validation.
     *
     * @param PurchasableInterface $purchasable   Purchasable
     * @param int                  $stockRequired Stock required
     * @param bool                 $useStock      Use stock
     *
     * @return bool|int Is valid or the number of elements that can be used
     */
    public function isStockAvailable(
        PurchasableInterface $purchasable,
        $stockRequired,
        $useStock
    ) {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }

        /**
         * @var PackInterface $purchasable
         */
        $isInheritStock = ElcodiArticleStock::INHERIT_STOCK === $purchasable->getStockType();
        $isInheritanceValid = $this->areValidByLoadedValidators(
            $purchasable->getPurchasables(),
            $stockRequired,
            $isInheritStock
        );

        /**
         * Happens when their related elements do not allow this pack to be used.
         */
        if (false === $isInheritanceValid) {
            return false;
        }

        $isPackValid = $this->isValidUsingSimplePurchasableValidation(
            $purchasable,
            $stockRequired,
            !$isInheritStock
        );

        /**
         * Happens when the pack itself is not valid.
         */
        if (false === $isPackValid) {
            return false;
        }

        /**
         * At this point we need to check both values for determining the result
         * value of the whole validation. In this case, both results allow the
         * pack to be used.
         */
        if (true === $isInheritanceValid && true === $isPackValid) {
            return true;
        }

        /**
         * Some of them have returned an int value. There is a problem with
         * stock, so we need to check which one is valid.
         */
        return $isInheritStock
            ? $isInheritanceValid
            : $isPackValid;
    }
}
