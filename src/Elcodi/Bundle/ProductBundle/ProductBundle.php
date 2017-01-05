<?php

namespace Elcodi\Bundle\ProductBundle;

use Mmoreram\SymfonyBundleDependencies\DependentBundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\ProductBundle\CompilerPass\MappingCompilerPass;
use Elcodi\Bundle\ProductBundle\CompilerPass\ProductImageResolverCompilerPass;

use Elcodi\Bundle\CoreBundle\Abstracts\AbstractElcodiBundle;
use Elcodi\Bundle\ProductBundle\DependencyInjection\ProductExtension;

class ProductBundle extends AbstractElcodiBundle implements DependentBundleInterface
{
	/**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingCompilerPass());
		$container->addCompilerPass(new ProductImageResolverCompilerPass());
    }
	
	/**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ProductExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces.
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle',
			'Elcodi\Bundle\LanguageBundle\ElcodiLanguageBundle',
        ];
    }
}
