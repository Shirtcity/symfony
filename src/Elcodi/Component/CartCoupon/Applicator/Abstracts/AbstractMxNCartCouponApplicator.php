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

namespace Elcodi\Component\CartCoupon\Applicator\Abstracts;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\CartCoupon\Applicator\ExpressionLanguage\ExpressionLanguageFunctionCollector;
use Elcodi\Component\CartCoupon\Applicator\Interfaces\CartCouponApplicatorInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\PriceResolver\ArticlePriceResolver;

/**
 * Class AbstractMxNCartCouponApplicator.
 */
abstract class AbstractMxNCartCouponApplicator implements CartCouponApplicatorInterface
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    protected $currencyConverter;

    /**
     * @var ExpressionLanguageFunctionCollector
     *
     * ExpressionLanguageFunction collector
     */
    protected $expressionLanguageFunctionCollector;
	
	/**
	 * @var ArticlePriceResolver
	 * 
	 * ArticlePriceResolver resolver
	 */
	protected $articlePriceResolver;

    /**
     * Construct method.
     *
     * @param CurrencyWrapper                     $currencyWrapper                     Currency wrapper
     * @param CurrencyConverter                   $currencyConverter                   Currency converter
     * @param ExpressionLanguageFunctionCollector $expressionLanguageFunctionCollector ExpressionLanguageFunction collector
	 * @param ArticlePriceResolver				  $articlePriceResolver				   ArticlePriceResolver resolver
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter,
        ExpressionLanguageFunctionCollector $expressionLanguageFunctionCollector,
		ArticlePriceResolver $articlePriceResolver
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->expressionLanguageFunctionCollector = $expressionLanguageFunctionCollector;
		$this->articlePriceResolver = $articlePriceResolver;
    }

    /**
     * Get the id of the Applicator.
     *
     * @return string Applicator id
     */
    public static function id()
    {
        return 3;
    }

    /**
     * Can be applied.
     *
     * @param CartInterface   $cart   Cart
     * @param CouponInterface $coupon Coupon
     *
     * @return bool Can be applied
     */
    public function canBeApplied(
        CartInterface $cart,
        CouponInterface $coupon
    ) {
        return
            $coupon->getType() === self::id() &&
            1 === preg_match($this->regexp(), $coupon->getValue());
    }

    /**
     * Get the regular expression.
     *
     * @return string Regular Expression
     */
    abstract public function regexp();

    /**
     * Get expression language instance.
     *
     * @return ExpressionLanguage
     */
    protected function getExpressionLanguageInstance()
    {
        $expressionLanguage = new ExpressionLanguage();

        $this
            ->expressionLanguageFunctionCollector
            ->registerFunction($expressionLanguage);

        return $expressionLanguage;
    }

    /**
     * Evaluate purchasables.
     */
    protected function evaluatePurchasableType(
        PurchasableInterface $purchasable,
        $modifiers
    ) {
        if (empty($modifiers)) {
            return true;
        }

        if (
            false === strpos($modifiers, 'P') &&
            false === strpos($modifiers, 'V') &&
            false === strpos($modifiers, 'K')
        ) {
            return true;
        }

        if (
            $purchasable instanceof ArticleInterface &&
            false !== strpos($modifiers, 'P')
        ) {
            return true;
        }     

        return false;
    }
}
