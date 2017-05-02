<?php

namespace Elcodi\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;

use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;

/**
 * Class ProductData.
 */
class ProductData extends AbstractFixture implements DependentFixtureInterface
{
    use ImageManagerTrait;

	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Product
         *
         * @var CurrencyInterface     $currency
         * @var ObjectDirector        $prodcutDirector
         */
        $currency = $this->getReference('currency-dollar');
        $productReference = $this->getDirector('product');
		
		$productPrices = new ArrayCollection();
		$productPrices[] = Money::create(10, $currency);
        
        $printMethod = $this->getReference('printMethod');
        
        $product = $productReference
            ->create()
            ->setName('T-Shirt')
            ->setSlug('t-shirt')
            ->setDescription('my T-Shirt description')
            ->setHeight(10)
			->setWidth(10)
			->setdepth(10)
			->setWeight(10)
            ->setEnabled(true)
			->setPrices($productPrices)
            ->addPrintMethod($printMethod);
        
        $this->storeProductImage(
            $product,
            'product.jpg'
        );

        $productReference->save($product);
        $this->addReference('product', $product);

    }
    
    /**
     * Steps necessary to store an image.
     *
     * @param ImagesContainerWithPrincipalImageInterface $imageContainer Image Container
     * @param string                                     $imageName      Image name
     *
     * @return $this Self object
     */
    protected function storeProductImage(
        ImagesContainerWithPrincipalImageInterface $imageContainer,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        
        $image = $this->storeImage($imagePath);

        $imageContainer->addImage($image);
        $imageContainer->setPrincipalImage($image);

        return $this;
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
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
			'Elcodi\Bundle\ProductBundle\DataFixtures\ORM\PrintMethodData',
        ];
    }
}
