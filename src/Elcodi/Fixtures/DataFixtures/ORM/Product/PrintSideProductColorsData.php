<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Fixtures\DataFixtures\ORM\Product\Abstracts\AbstractPrintSideProductColorsData;

/**
 * Class PrintSideProductColorsData
 */
class PrintSideProductColorsData extends AbstractPrintSideProductColorsData implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {    
        $printSideProductColorsFactory = $this->getFactory('print_side_product_colors');
        $objectManager = $this->get('elcodi.object_manager.print_side_product_colors');
        
        $printSide = $this->getReference('print-side');
        $productColorsBlack = $this->getReference('product-colors-t-shirt-black');
        
        $printSideProductColors = $printSideProductColorsFactory->create();
        
        $printSideProductColors
            ->setSide($printSide)
            ->setProductColors($productColorsBlack);
        
        $this->storePrintSideProductColorsImage(
            $printSideProductColors,
            'product-1.jpg'
        );

        $objectManager->persist($printSideProductColors);

        $this->addReference('print-side-product-colors', $printSideProductColors);          
        
        $objectManager->flush($printSideProductColors);
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
            'Elcodi\Fixtures\DataFixtures\ORM\Product\PrintSideData',
            'Elcodi\Fixtures\DataFixtures\ORM\Product\ProductColorsData',
        ];
    }
}