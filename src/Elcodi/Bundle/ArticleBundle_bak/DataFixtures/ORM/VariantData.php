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

namespace Elcodi\Bundle\ArticleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\ArticleBundle\DataFixtures\ORM\Traits\ArticleWithImagesTrait;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

class VariantData extends AbstractFixture implements DependentFixtureInterface
{
    use ArticleWithImagesTrait;

    /**
     * Loads sample fixtures for article Variant entities.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ArticleInterface  $articleWithVariants
         * @var CurrencyInterface $currency
         * @var ObjectDirector    $variantDirector
         */
        $currency = $this->getReference('currency-dollar');
        $articleWithVariants = $this->getReference('article-with-variants');
        $variantDirector = $this->getDirector('article_variant');

        /**
         * @var ValueInterface $optionWhite
         * @var ValueInterface $optionRed
         * @var ValueInterface $optionSmall
         * @var ValueInterface $optionLarge
         */
        $optionWhite = $this->getReference('value-color-white');
        $optionRed = $this->getReference('value-color-red');
        $optionSmall = $this->getReference('value-size-small');
        $optionLarge = $this->getReference('value-size-large');

        /**
         * Variant White-Small.
         */
        $variantWhiteSmall = $variantDirector
            ->create()
            ->setSku('variant-white-small-sku')
            ->setStock(100)
            ->setArticle($articleWithVariants)
            ->addOption($optionWhite)
            ->addOption($optionSmall)
            ->setPrice(Money::create(1500, $currency))
            ->setHeight(13)
            ->setWidth(12)
            ->setDepth(19)
            ->setWeight(125)
            ->setEnabled(true);

        $articleWithVariants->setPrincipalVariant($variantWhiteSmall);

        $variantDirector->save($variantWhiteSmall);
        $this->addReference('variant-white-small', $variantWhiteSmall);

        /**
         * Variant White-Large.
         */
        $variantWhiteLarge = $variantDirector
            ->create()
            ->setSku('variant-white-large-sku')
            ->setStock(100)
            ->setArticle($articleWithVariants)
            ->addOption($optionWhite)
            ->addOption($optionLarge)
            ->setPrice(Money::create(1800, $currency))
            ->setHeight(12)
            ->setWidth(11)
            ->setDepth(45)
            ->setWeight(155)
            ->setEnabled(true);

        $variantDirector->save($variantWhiteLarge);
        $this->addReference('variant-white-large', $variantWhiteLarge);

        /**
         * Variant Red-Small.
         */
        $variantRedSmall = $variantDirector
            ->create()
            ->setSku('variant-red-small-sku')
            ->setStock(100)
            ->setArticle($articleWithVariants)
            ->addOption($optionRed)
            ->addOption($optionSmall)
            ->setPrice(Money::create(1500, $currency))
            ->setHeight(19)
            ->setWidth(9)
            ->setDepth(33)
            ->setWeight(1000)
            ->setEnabled(true);

        $this->storeArticleImage(
            $variantRedSmall,
            'variant.jpg'
        );

        $variantDirector->save($variantRedSmall);
        $this->addReference('variant-red-small', $variantRedSmall);

        /**
         * Variant Red-Large.
         */
        $variantRedLarge = $variantDirector
            ->create()
            ->setSku('variant-red-large-sku')
            ->setStock(100)
            ->setArticle($articleWithVariants)
            ->addOption($optionRed)
            ->addOption($optionLarge)
            ->setPrice(Money::create(1800, $currency))
            ->setHeight(50)
            ->setWidth(30)
            ->setDepth(18)
            ->setWeight(70)
            ->setEnabled(true);

        $variantDirector->save($variantRedLarge);
        $this->addReference('variant-red-large', $variantRedLarge);
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
            'Elcodi\Bundle\AttributeBundle\DataFixtures\ORM\AttributeData',
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\Bundle\ArticleBundle\DataFixtures\ORM\ArticleData',
        ];
    }
}
