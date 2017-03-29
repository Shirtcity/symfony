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

namespace Elcodi\Bundle\CartCouponBundle\Tests\Functional\Applicator;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class MxNCartCouponApplicatorTest.
 */
class MxNCartCouponApplicatorTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiCouponBundle',
            'ElcodiArticleBundle',
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * Test getCouponAbsoluteValue.
     *
     * @dataProvider dataGetCouponAbsoluteValue
     */
    public function testGetCouponAbsoluteValue(
        $value,
        $result
    ) {
        $cartManager = $this->get('elcodi.manager.cart');
        $cartCouponManager = $this->get('elcodi.manager.cart_coupon');
        $cart = $this->find('cart', 1);

        $this
            ->get('elcodi.event_dispatcher.cart')
            ->dispatchCartLoadEvents($cart);

        $cartManager->addPurchasable(
            $cart,
            $this->find('purchasable', 1),
            4
        );

        $cartManager->addPurchasable(
            $cart,
            $this->find('purchasable', 2),
            2
        );

        $cartManager->addPurchasable(
            $cart,
            $this->find('purchasable', 3),
            3
        );

        $coupon = $this
            ->getRepository('coupon')
            ->findOneBy(
                ['code' => '2x1category1']
            );

        $coupon->setValue($value);
        $cartCouponManager->addCoupon(
            $cart,
            $coupon
        );

        $this->assertEquals(
            $result,
            $cart->getAmount()->getAmount()
        );

        $cartCouponManager->removeCoupon(
            $cart,
            $coupon
        );

        $cartManager->emptyLines(
            $cart
        );
    }

    /**
     * Data for testGetCouponAbsoluteValue.
     */
    public function dataGetCouponAbsoluteValue()
    {
        return [

            // Specific scenarios
            ['2x1', 50],
            ['2x1:p("3,7,9")', 80],
            ['2x1:c(2)&p("3,7")', 90],
            ['2x1:c(2)&p("3,7"):P', 90],
            ['2x1:c(2)&p("3,7"):V', 90],
            ['2x1:c(2)&p("3,7"):K', 90],
            ['2x1:p(9):P', 90],
            ['2x1:p(9):K', 90],
            ['2x1:c(1)', 80],
            ['2x1:c(2)', 60],
            ['3x2:c(2)', 80],
            ['10x1:c(2)', 50],
            ['4x3:c(2)', 80],
            ['2x1::V', 90],

            // Group scenarios (with G modifier)
            ['2x1::G', 50],
            ['2x1:c(2)&p("3,7"):G', 90],
            ['2x1:c(2)&p("3,7"):PG', 90],
            ['2x1:c(2)&p("3,7"):VG', 90],
            ['2x1:c(2)&p("3,7"):KG', 90],
            ['2x1:p(9):PG', 90],
            ['2x1:p(9):KG', 90],
            ['2x1:c(1):G', 80],
            ['2x1:c(2):G', 60],
            ['3x2:c(2):G', 70],
            ['9x1:c(2):G', 90],
            ['9x2:c(2):G', 90],
            ['9x2:c(2):VG', 90],
            ['10x1:c(2):G', 90],
            ['2x1::VG', 90],
        ];
    }
}
