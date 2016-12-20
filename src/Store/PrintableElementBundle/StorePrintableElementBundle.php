<?php

namespace Store\PrintableElementBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Store\ProductBundle\DependencyInjection\StoreProductExtension;

/**
 * Class StoreProductBundle
 */
class StorePrintableElementBundle extends AbstractElcodiBundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new StoreProductExtension();
    }
}
