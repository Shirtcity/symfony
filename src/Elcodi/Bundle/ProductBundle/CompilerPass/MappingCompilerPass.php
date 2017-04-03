<?php


namespace Elcodi\Bundle\ProductBundle\CompilerPass;

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
                    'product',
					'product_color',
					'product_colors',
					'product_size',
					'product_sizes',
					'product_manufacturer',
					'print_side',
					'print_side_type',
                ]
            );
    }
}
