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

namespace Elcodi\Bundle\CartBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class CartData.
 */
class CartData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Carts.
         *
         * @var CartInterface     $emptyCart
         * @var CartInterface     $fullCart
         * @var CustomerInterface $customer1
         * @var CustomerInterface $customer2
         * @var ArticleInterface  $article
         * @var ArticleInterface  $articleReduced
         * @var CartLineInterface $cartLine1
         * @var CartLineInterface $cartLine2
         * @var ObjectDirector    $cartDirector
         * @var ObjectDirector    $cartLineDirector
         * @var AddressInterface  $address1
         * @var AddressInterface  $address2
         */
        $cartDirector = $this->getDirector('cart');
        $cartLineDirector = $this->getDirector('cart_line');

		$currency = $this->getReference('currency-dollar');
		
        $customer1 = $this->getReference('customer-1');
        $customer2 = $this->getReference('customer-2');
		
        $article = $this->getReference('article');
        $articleReduced = $this->getReference('article-reduced');
		
		$articlePrice = $this
			->get('price_resolver.article')
			->getPrice($article, $currency);
		
		$articleReducedPrice = $this
                ->get('price_resolver.article')
                ->getPrice($articleReduced, $currency);
		
        $address1 = $this->getReference('address-sant-celoni');
        $address2 = $this->getReference('address-viladecavalls');

        /**
         * Empty cart.
         */
        $emptyCart = $cartDirector
            ->create()
            ->setCustomer($customer1);

        $cartDirector->save($emptyCart);
        $this->addReference('empty-cart', $emptyCart);	
		

        /**
         * Full cart.
         */
        $fullCart = $cartDirector
            ->create()
            ->setCustomer($customer2);

        $cartLine1 = $cartLineDirector
            ->create()
            ->setPurchasable($article)
            ->setPurchasableAmount($articlePrice)
            ->setAmount($articlePrice)
            ->setQuantity(2)
            ->setCart($fullCart);

        $cartLine2 = $cartLineDirector
            ->create()
            ->setPurchasable($articleReduced)
            ->setPurchasableAmount($articleReducedPrice)
            ->setAmount($articleReducedPrice)
            ->setQuantity(2)
            ->setCart($fullCart);

        $fullCart
            ->addCartLine($cartLine1)
            ->addCartLine($cartLine2);

        $fullCart->setBillingAddress($address1);
        $fullCart->setDeliveryAddress($address2);

        $cartDirector->save($fullCart);
        $this->addReference('full-cart', $fullCart);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\ArticleBundle\DataFixtures\ORM\ArticleData',
            'Elcodi\Bundle\UserBundle\DataFixtures\ORM\CustomerData',
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\AddressData',
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
        ];
    }
}
