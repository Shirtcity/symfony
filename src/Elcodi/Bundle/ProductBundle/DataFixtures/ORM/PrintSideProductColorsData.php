<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;
use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class PrintSideProductColorsData.
 */
class PrintSideProductColorsData extends AbstractFixture implements DependentFixtureInterface
{  
    use ImageManagerTrait;
    
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $printSideProductColorsDirector = $this->getDirector('print_side_product_colors');
        
        $printSide = $this->getReference('print-side');
        $productColors = $this->getReference('product-colors');

        $printSideProductColors = $printSideProductColorsDirector
            ->create()
            ->setSide($printSide)
            ->setProductColors($productColors);
        
        $this->storePrintSideProductColorsImage(
            $printSideProductColors,
            'print-side.png'
        );

        $printSideProductColorsDirector->save($printSideProductColors);
        $this->addReference('print-side-product-colors', $printSideProductColors);
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
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductColorsData',
        ];
    }
    
    /**
     * Steps necessary to store an image.
     *
     * @param ImagesContainerInterface $imageContainer Image Container
     * @param string                                     $imageName      Image name
     *
     * @return $this Self object
     */
    protected function storePrintSideProductColorsImage(
        ImagesContainerInterface $imageContainer,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        
        $image = $this->storeImage($imagePath);

        $imageContainer->setImage($image);

        return $this;
    }
}
