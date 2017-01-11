<?php

namespace Elcodi\Admin\PrintableBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Elcodi\Admin\PrintableBundle\DependencyInjection\AdminPrintableExtension;
use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;

/**
 * Class AdminPrintableBundle
 */
class AdminPrintableBundle extends AbstractElcodiBundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new AdminPrintableExtension();
    }
}