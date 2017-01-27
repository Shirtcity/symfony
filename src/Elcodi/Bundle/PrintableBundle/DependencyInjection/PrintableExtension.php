<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\PrintableBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class PrintableExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'printable';

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
            'elcodi.entity.foilcolor.class' => $config['mapping']['foilcolor']['class'],
            'elcodi.entity.foilcolor.mapping_file' => $config['mapping']['foilcolor']['mapping_file'],
            'elcodi.entity.foilcolor.manager' => $config['mapping']['foilcolor']['manager'],
            'elcodi.entity.foilcolor.enabled' => $config['mapping']['foilcolor']['enabled'],

            'elcodi.entity.font.class' => $config['mapping']['font']['class'],
            'elcodi.entity.font.mapping_file' => $config['mapping']['font']['mapping_file'],
            'elcodi.entity.font.manager' => $config['mapping']['font']['manager'],
            'elcodi.entity.font.enabled' => $config['mapping']['font']['enabled'],

            'elcodi.entity.design.class' => $config['mapping']['design']['class'],
            'elcodi.entity.design.mapping_file' => $config['mapping']['design']['mapping_file'],
            'elcodi.entity.design.manager' => $config['mapping']['design']['manager'],
            'elcodi.entity.design.enabled' => $config['mapping']['design']['enabled'],

            'elcodi.entity.design_variant.class' => $config['mapping']['design_variant']['class'],
            'elcodi.entity.design_variant.mapping_file' => $config['mapping']['design_variant']['mapping_file'],
            'elcodi.entity.design_variant.manager' => $config['mapping']['design_variant']['manager'],
            'elcodi.entity.design_variant.enabled' => $config['mapping']['design_variant']['enabled'],

            'elcodi.entity.text.class' => $config['mapping']['text']['class'],
            'elcodi.entity.text.mapping_file' => $config['mapping']['text']['mapping_file'],
            'elcodi.entity.text.manager' => $config['mapping']['text']['manager'],
            'elcodi.entity.text.enabled' => $config['mapping']['text']['enabled'],

            'elcodi.entity.text_variant.class' => $config['mapping']['text_variant']['class'],
            'elcodi.entity.text_variant.mapping_file' => $config['mapping']['text_variant']['mapping_file'],
            'elcodi.entity.text_variant.manager' => $config['mapping']['text_variant']['manager'],
            'elcodi.entity.text_variant.enabled' => $config['mapping']['text_variant']['enabled'],

            'elcodi.entity.photo.class' => $config['mapping']['photo']['class'],
            'elcodi.entity.photo.mapping_file' => $config['mapping']['photo']['mapping_file'],
            'elcodi.entity.photo.manager' => $config['mapping']['photo']['manager'],
            'elcodi.entity.photo.enabled' => $config['mapping']['photo']['enabled'],

            'elcodi.entity.photo_variant.class' => $config['mapping']['photo_variant']['class'],
            'elcodi.entity.photo_variant.mapping_file' => $config['mapping']['photo_variant']['mapping_file'],
            'elcodi.entity.photo_variant.manager' => $config['mapping']['photo_variant']['manager'],
            'elcodi.entity.photo_variant.enabled' => $config['mapping']['photo_variant']['enabled'],


            'elcodi.entity.printable_variant.class' => $config['mapping']['printable_variant']['class'],
            'elcodi.entity.printable_variant.mapping_file' => $config['mapping']['printable_variant']['mapping_file'],
            'elcodi.entity.printable_variant.manager' => $config['mapping']['printable_variant']['manager'],
            'elcodi.entity.printable_variant.enabled' => $config['mapping']['printable_variant']['enabled'],
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
            'repositories',
            'factories',
            /*
            'wrappers',
            'commands',
            'adapters',
            'expressionLanguage',

            'objectManagers',

            'twig',
            'directors',
            */
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
            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FoilColorInterface' => 'elcodi.entity.foilcolor.class',

            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FontInterface' => 'elcodi.entity.font.class',

            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignInterface' => 'elcodi.entity.design.class',
            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignVariantInterface' => 'elcodi.entity.design_variant.class',

            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PhotoInterface' => 'elcodi.entity.photo.class',
            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PhotoVariantInterface' => 'elcodi.entity.photo_variant.class',

            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextInterface' => 'elcodi.entity.text.class',
            'Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextVariantInterface' => 'elcodi.entity.text_variant.class',
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
