<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
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

namespace Elcodi\Admin\PluginBundle\Builder;

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
                    ->setName('admin.plugin.plural')
                    ->setCode('puzzle-piece')
                    ->setUrl('admin_plugin_list')
                    ->setPriority(-30)
                    ->setTag('settings')
                    ->setActiveUrls([
                        'admin_plugin_configure',
                    ])
                    ->addSubnode(
                        $this
                            ->menuNodeFactory
                            ->create()
                            ->setName('admin.plugin.app_store')
                            ->setUrl('admin_plugin_list')
                            ->setPriority(9999)
                    )
            )
            ->addSubnode(
                $this
                    ->menuNodeFactory
                    ->create()
                    ->setName('plugin_type.social')
                    ->setCode('share-alt')
                    ->setTag('settings')
                    ->setPriority(32)
            );
    }
}
