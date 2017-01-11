<?php

namespace Elcodi\Admin\PrintableBundle\Builder;

use Elcodi\Component\Menu\Builder\Abstracts\AbstractMenuBuilder;
use Elcodi\Component\Menu\Builder\Interfaces\MenuBuilderInterface;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;

/**
 * Class MenuBuilder
 */
class MenuBuilder extends AbstractMenuBuilder implements MenuBuilderInterface
{
    /**
     * Build the menu
     *
     * @param MenuInterface $menu Menu
     */
    public function build(MenuInterface $menu)
    {
        $menu
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('admin.printable.single')
                    ->setCode('print')
                    ->setTag('catalog')

                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('FoilColor')
                            ->setUrl('admin_foilcolor_list')
                            ->setTag('catalog')
                            ->setPriority(40)
                            ->setActiveUrls([
                                'admin_foilcolor_edit',
                                'admin_foilcolor_new',
                            ])
                    )
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('Font')
                            ->setUrl('admin_font_list')
                            ->setTag('catalog')
                            ->setPriority(40)
                            ->setActiveUrls([
                                'admin_font_edit',
                                'admin_font_new',
                            ])
                    )
            );

    }
}
