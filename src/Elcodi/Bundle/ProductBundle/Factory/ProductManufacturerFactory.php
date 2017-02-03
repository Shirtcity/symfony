<?php


namespace Elcodi\Bundle\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Bundle\ProductBundle\Entity\ProductManufacturer;

/**
 * Class ProductManufacturerFactory.
 */
class ProductManufacturerFactory extends AbstractFactory
{
    /**
     * Creates an instance of ProductManufacturer.
     *
     * @return ProductManufacturer New ProductManufacturer entity
     */
    public function create()
    {
        /**
         * @var ProductManufacturer $product_manufacturer
         */
        $classNamespace = $this->getEntityNamespace();
        $product_manufacturer = new $classNamespace();
        $product_manufacturer
            ->setImages(new ArrayCollection())
            ->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $product_manufacturer;
    }
}
