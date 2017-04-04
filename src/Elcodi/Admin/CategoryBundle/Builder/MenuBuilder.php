<?php

namespace Elcodi\Admin\CategoryBundle\Builder;

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
                    ->setName('admin.category.plural')
                    ->setCode('tags')
                    ->setUrl('admin_category_list')
                    ->setTag('catalog')
                    ->setPriority(37)
						->addSubnode(
							$this
								->menuNodeFactory
								->create()
								->setName('admin.section.category.plural')
								->setUrl('admin_section_category_list')
								->setActiveUrls([
									'admin_section_category_edit',
									'admin_section_category_new',
								])
						)
						->addSubnode(
							$this
								->menuNodeFactory
								->create()
								->setName('admin.product.category.plural')
								->setUrl('admin_product_category_list')
								->setActiveUrls([
									'admin_product_category_edit',
									'admin_product_category_new',
								])
						)
						->addSubnode(
							$this
								->menuNodeFactory
								->create()
								->setName('admin.design.category.plural')
								->setUrl('admin_design_category_list')
								->setActiveUrls([
									'admin_design_category_edit',
									'admin_design_category_new',
								])
						)
            );
    }
}
