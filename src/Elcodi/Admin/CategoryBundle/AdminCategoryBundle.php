<?php

namespace Elcodi\Admin\CategoryBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Elcodi\Admin\CategoryBundle\DependencyInjection\AdminCategoryExtension;
use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;

class AdminCategoryBundle extends AbstractElcodiBundle
{
	/**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new AdminCategoryExtension();
    }
}
