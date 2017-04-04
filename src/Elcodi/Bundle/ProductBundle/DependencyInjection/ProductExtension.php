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
			
			'elcodi.entity.product_manufacturer.class' => $config['mapping']['product_manufacturer']['class'],
            'elcodi.entity.product_manufacturer.mapping_file' => $config['mapping']['product_manufacturer']['mapping_file'],
            'elcodi.entity.product_manufacturer.manager' => $config['mapping']['product_manufacturer']['manager'],
            'elcodi.entity.product_manufacturer.enabled' => $config['mapping']['product_manufacturer']['enabled'],
			
			'elcodi.entity.print_side.class' => $config['mapping']['print_side']['class'],
            'elcodi.entity.print_side.mapping_file' => $config['mapping']['print_side']['mapping_file'],
            'elcodi.entity.print_side.manager' => $config['mapping']['print_side']['manager'],
            'elcodi.entity.print_side.enabled' => $config['mapping']['print_side']['enabled'],
			
			'elcodi.entity.print_side_type.class' => $config['mapping']['print_side_type']['class'],
            'elcodi.entity.print_side_type.mapping_file' => $config['mapping']['print_side_type']['mapping_file'],
            'elcodi.entity.print_side_type.manager' => $config['mapping']['print_side_type']['manager'],
            'elcodi.entity.print_side_type.enabled' => $config['mapping']['print_side_type']['enabled'],
			
			'elcodi.entity.print_side_area.class' => $config['mapping']['print_side_area']['class'],
            'elcodi.entity.print_side_area.mapping_file' => $config['mapping']['print_side_area']['mapping_file'],
            'elcodi.entity.print_side_area.manager' => $config['mapping']['print_side_area']['manager'],
            'elcodi.entity.print_side_area.enabled' => $config['mapping']['print_side_area']['enabled'],
			
			'elcodi.entity.print_side_product_colors.class' => $config['mapping']['print_side_product_colors']['class'],
            'elcodi.entity.print_side_product_colors.mapping_file' => $config['mapping']['print_side_product_colors']['mapping_file'],
            'elcodi.entity.print_side_product_colors.manager' => $config['mapping']['print_side_product_colors']['manager'],
            'elcodi.entity.print_side_product_colors.enabled' => $config['mapping']['print_side_product_colors']['enabled'],
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
			'eventListeners',
			'directors',
			'objectManagers',
			/*
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
            'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductInterface'				=> 'elcodi.entity.product.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductManufacturerInterface'	=> 'elcodi.entity.product_manufacturer.class',	
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorInterface'			=> 'elcodi.entity.product_color.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface'			=> 'elcodi.entity.product_colors.class',			
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizeInterface'			=> 'elcodi.entity.product_size.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductSizesInterface'			=> 'elcodi.entity.product_sizes.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface'				=> 'elcodi.entity.print_side.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideTypeInterface'			=> 'elcodi.entity.print_side_type.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface'			=> 'elcodi.entity.print_side_area.class',
			'Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideProductColorsInterface'	=> 'elcodi.entity.print_side_product_colors.class',
        ];
    }
}
