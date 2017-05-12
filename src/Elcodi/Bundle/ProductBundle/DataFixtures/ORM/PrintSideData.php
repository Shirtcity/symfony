<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerInterface;
use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;

/**
 * Class PrintSideData.
 */
class PrintSideData extends AbstractFixture implements DependentFixtureInterface
{  
    use ImageManagerTrait;
    
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $printSideDirector = $this->getDirector('print_side');
        
        $printSideType = $this->getReference('print-side-type-front');
        $product = $this->getReference('product');

        $printSide = $printSideDirector
            ->create()
            ->setType($printSideType)
            ->setProduct($product)
            ->setEnabled(true);
        
        $this->storePrintSideImage(
            $printSide,
            'print-side.png'
        );

        $printSideDirector->save($printSide);
        $this->addReference('print-side', $printSide);
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
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintSideTypeData',
            'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\ProductData',
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
    protected function storePrintSideImage(
        ImagesContainerInterface $imageContainer,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        
        $image = $this->storeImage($imagePath);

        $imageContainer->setImage($image);

        return $this;
    }
}
