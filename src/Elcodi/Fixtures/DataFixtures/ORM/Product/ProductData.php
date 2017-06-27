<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\EntityTranslator\Services\Interfaces\EntityTranslatorInterface;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductData
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CategoryInterface         $menCategory
         * @var CategoryInterface         $womenCategory
         * @var CurrencyInterface         $currencyUsd
         * @var CurrencyInterface         $currencyEur
         * @var ObjectManager             $productObjectManager
         * @var EntityTranslatorInterface $entityTranslator
         */        
        $productFactory = $this->getFactory('product');
        $menCategory = $this->getReference('category-men');
        $womenCategory = $this->getReference('category-women');
        $currencyUsd = $this->getReference('currency-USD');
        $currencyEur = $this->getReference('currency-EUR');
        $productObjectManager = $this->get('elcodi.object_manager.product');
        $entityTranslator = $this->get('elcodi.entity_translator');
        
        /**
         * T-Shirt
         *
         * @var ProductInterface $product
         */
        $product = $productFactory->create();
        
        $product
            ->setName('T-Shirt')
            ->setSlug('t-shirt')
            ->setMetaTitle('T-Shirt')
            ->setMetaDescription('Ibiza Lips English')
            ->setMetaKeywords('T-Shirt')
            ->setPrice(Money::create(799, $currencyUsd));

        $productObjectManager->persist($product);

        $this->addReference('product-t-shirt', $product);
        $productObjectManager->flush($product);

        $entityTranslator->save($product, [
            'en' => [
                'name'            => 'Ibiza Lips English',
                'slug'            => 'ibiza-lips-en',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Ibiza Lips English',
                'metaDescription' => 'Ibiza Lips English',
                'metaKeywords'    => 'Ibiza Lips English',
            ],
            'es' => [
                'name'            => 'Ibiza Lips Spanish',
                'slug'            => 'ibiza-lips-es',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Ibiza Lips Spanish',
                'metaDescription' => 'Ibiza Lips Spanish',
                'metaKeywords'    => 'Ibiza Lips Spanish',
            ],
            'fr' => [
                'name'            => 'Ibiza Lips Français',
                'slug'            => 'ibiza-lips-fr',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Ibiza Lips Français',
                'metaDescription' => 'Ibiza Lips Français',
                'metaKeywords'    => 'Ibiza Lips Français',
            ],
            'ca' => [
                'name'            => 'Ibiza Lips Català',
                'slug'            => 'ibiza-lips-ca',
                'description'     => 'Sed venenatis mauris eros, sit amet dapibus turpis consectetur et.
                Etiam blandit erat libero. Integer a elit a tortor scelerisque
                bibendum quis eget tortor. Donec vitae tempor tellus.',
                'metaTitle'       => 'Ibiza Lips Català',
                'metaDescription' => 'Ibiza Lips Català',
                'metaKeywords'    => 'Ibiza Lips Català',
            ],
        ]);

        $productObjectManager->flush();        
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Fixtures\DataFixtures\ORM\Currency\CurrencyData',
            'Elcodi\Fixtures\DataFixtures\ORM\Category\CategoryData',
            'Elcodi\Fixtures\DataFixtures\ORM\Attribute\AttributeData',
            'Elcodi\Fixtures\DataFixtures\ORM\Store\StoreData',
        ];
    }
}
