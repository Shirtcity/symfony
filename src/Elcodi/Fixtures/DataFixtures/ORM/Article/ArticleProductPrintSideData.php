<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Article;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ArticleProductPrintSideData
 */
class ArticleProductPrintSideData  extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $articleProductPrintSideFactory = $this->getFactory('article_product_print_side');
        $objectManager = $this->get('elcodi.object_manager.article_product_print_side');
        
        $articleProductTshirt = $this->getReference('article-product-t-shirt');
        $printSide = $this->getReference('print-side');
                
        $articleProductPrintSide = $articleProductPrintSideFactory->create();
        
        $articleProductPrintSide
            ->setArticleProduct($articleProductTshirt)
            ->setPrintSide($printSide);

        $objectManager->persist($articleProductPrintSide);
        
        $this->addReference('article-product-print-side-t-shirt-front', $articleProductPrintSide);
        
        $objectManager->flush($articleProductPrintSide);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Article\ArticleProductData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\PrintSideData',
        ];
    }
}
