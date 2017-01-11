<?php
namespace Elcodi\Admin\PrintableBundle\DependencyInjection;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;

/**
 * Class AdminPrintableExtension
 */
class AdminPrintableExtension extends AbstractExtension
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'admin_printable';

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Config files to load
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'formTypes',
            'menu',
            'services'
        ];
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return self::EXTENSION_NAME;
    }
}