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
			
			'elcodi.entity.product_color.class' => $config['mapping']['product_color']['class'],
            'elcodi.entity.product_color.mapping_file' => $config['mapping']['product_color']['mapping_file'],
            'elcodi.entity.product_color.manager' => $config['mapping']['product_color']['manager'],
            'elcodi.entity.product_color.enabled' => $config['mapping']['product_color']['enabled'],
			
			'elcodi.entity.product_colors.class' => $config['mapping']['product_colors']['class'],
            'elcodi.entity.product_colors.mapping_file' => $config['mapping']['product_colors']['mapping_file'],
            'elcodi.entity.product_colors.manager' => $config['mapping']['product_colors']['manager'],
            'elcodi.entity.product_colors.enabled' => $config['mapping']['product_colors']['enabled'],
			
			'elcodi.entity.product_size.class' => $config['mapping']['product_size']['class'],
            'elcodi.entity.product_size.mapping_file' => $config['mapping']['product_size']['mapping_file'],
            'elcodi.entity.product_size.manager' => $config['mapping']['product_size']['manager'],
            'elcodi.entity.product_size.enabled' => $config['mapping']['product_size']['enabled'],
			
			'elcodi.entity.product_sizes.class' => $config['mapping']['product_sizes']['class'],
            'elcodi.entity.product_sizes.mapping_file' => $config['mapping']['product_sizes']['mapping_file'],
            'elcodi.entity.product_sizes.manager' => $config['mapping']['product_sizes']['manager'],
            'elcodi.entity.product_sizes.enabled' => $config['mapping']['product_sizes']['enabled'],
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
        ];
    }
}
