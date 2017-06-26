<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Article;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ArticleProductData
 */
class ArticleProductData  extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $articleProductFactory = $this->getFactory('article_product');
        $objectManager = $this->get('elcodi.object_manager.article_product');
        
        $productTshirt = $this->getReference('product-t-shirt');
        $productColorsBlack = $this->getReference('product-colors-t-shirt-black');
                
        $articleProduct = $articleProductFactory->create();
        
        $articleProduct
            ->setProduct($productTshirt)
            ->setProductColors($productColorsBlack);

        $objectManager->persist($articleProduct);
        
        $this->addReference('article-product-t-shirt', $articleProduct);
        
        $objectManager->flush($articleProduct);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductColorsData',
        ];
    }
}
