<?php
namespace Elcodi\Bundle\PrintableBundle\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\CompilerPass\Abstracts\AbstractElcodiMappingCompilerPass;

/**
 * Class MappingCompilerPass.
 */
class MappingCompilerPass extends AbstractElcodiMappingCompilerPass
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this
            ->addEntityMappings(
                $container,
                [
                    'design',
                    'foilcolor',
                    'font',
                    'photo',
                    'text'
                ]
            );
    }
}
