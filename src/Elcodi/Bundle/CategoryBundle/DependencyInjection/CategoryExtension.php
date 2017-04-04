<?php

namespace Elcodi\Bundle\CategoryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class CategoryExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'category';

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
     * ConfigurationInterface, extension will use the Configuration to read all
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
            'elcodi.entity.category.class' => $config['mapping']['category']['class'],
            'elcodi.entity.category.mapping_file' => $config['mapping']['category']['mapping_file'],
            'elcodi.entity.category.manager' => $config['mapping']['category']['manager'],
            'elcodi.entity.category.enabled' => $config['mapping']['category']['enabled'],

            'elcodi.entity.design_category.class' => $config['mapping']['design_category']['class'],
            'elcodi.entity.design_category.mapping_file' => $config['mapping']['design_category']['mapping_file'],
            'elcodi.entity.design_category.manager' => $config['mapping']['design_category']['manager'],
            'elcodi.entity.design_category.enabled' => $config['mapping']['design_category']['enabled'],

            'elcodi.entity.product_category.class' => $config['mapping']['product_category']['class'],
            'elcodi.entity.product_category.mapping_file' => $config['mapping']['product_category']['mapping_file'],
            'elcodi.entity.product_category.manager' => $config['mapping']['product_category']['manager'],
            'elcodi.entity.product_category.enabled' => $config['mapping']['product_category']['enabled'],

            'elcodi.entity.section_category.class' => $config['mapping']['section_category']['class'],
            'elcodi.entity.section_category.mapping_file' => $config['mapping']['section_category']['mapping_file'],
            'elcodi.entity.section_category.manager' => $config['mapping']['section_category']['manager'],
            'elcodi.entity.section_category.enabled' => $config['mapping']['section_category']['enabled'],            
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
            'eventListeners',
			'factories',
			'repositories',
        ];
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
            'Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface' => 'elcodi.entity.category.class',
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
}