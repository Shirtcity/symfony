<?php

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;


/**
 * This is the class that loads and manages your bundle configuration.
 */
class ProductExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'product';

    /**
     * Get the Config file location.
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read allpurchasable_pack
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * Load Parametrization definition.
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            'elcodi.entity.product.class' => $config['mapping']['product']['class'],
            'elcodi.entity.product.mapping_file' => $config['mapping']['product']['mapping_file'],
            'elcodi.entity.product.manager' => $config['mapping']['product']['manager'],
            'elcodi.entity.product.enabled' => $config['mapping']['product']['enabled'],
			
			'elcodi.entity.product_variant.class' => $config['mapping']['product_variant']['class'],
            'elcodi.entity.product_variant.mapping_file' => $config['mapping']['product_variant']['mapping_file'],
            'elcodi.entity.product_variant.manager' => $config['mapping']['product_variant']['manager'],
            'elcodi.entity.product_variant.enabled' => $config['mapping']['product_variant']['enabled'],
        ];
    }

    /**
     * Config files to load.
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
			
            'services',
            'factories',			
            'repositories',
			'imageResolvers',
			'twig',
			/*
            'objectManagers',            
            'directors',
            'eventListeners',
            'adapters',
            'nameResolvers',
            'stockUpdaters',
            'stockValidators',            
			 * 
			 */
        ];
    }

    /**
     * Returns the extension alias, same value as extension name.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
	
	/**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Bundle\Product\Entity\Interfaces\ProductInterface' => 'elcodi.entity.product.class',
			'Elcodi\Bundle\Product\Entity\Interfaces\ProductVariantInterface' => 'elcodi.entity.product_variant.class',
        ];
    }
}
