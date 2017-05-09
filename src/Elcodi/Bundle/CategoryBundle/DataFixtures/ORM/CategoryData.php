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

namespace Elcodi\Bundle\CategoryBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryData.
 */
class CategoryData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadSectionCategories();
		$this->loadDesignCategories();
    }
	
	/**
	 * Load Section Categories
	 */
	private function loadSectionCategories()
	{
		/**
         * @var ObjectDirector $categoryDirector
         */
        $categoryDirector = $this->getDirector('section_category');
		
        /**
         * Category.
         *
         * @var CategoryInterface $rootCategory
         */
        $sectionCategory = $categoryDirector
            ->create()
            ->setName('section-category')
            ->setSlug('section-category')
            ->setEnabled(true)
            ->setRoot(true);

        $categoryDirector->save($sectionCategory);
        $this->addReference('section-category', $sectionCategory);

        /**
         * Category.
         *
         * @var CategoryInterface $category
         */
        $category = $categoryDirector
            ->create()
            ->setName('category')
            ->setSlug('category')
            ->setEnabled(true)
            ->setParent($sectionCategory)
            ->setRoot(false);

        $categoryDirector->save($category);
        $this->addReference('category', $category);

        /**
         * Second level category.
         *
         * @var CategoryInterface $secondLevelCategory
         */
        $secondLevelCategory = $categoryDirector
            ->create()
            ->setName('Second level category')
            ->setSlug('second-level-category')
            ->setEnabled(true)
            ->setParent($category)
            ->setRoot(false);

        $categoryDirector->save($secondLevelCategory);
        $this->addReference('second-level-category', $secondLevelCategory);
	}
	
	/**
	 * Load Design Categories
	 */
	private function loadDesignCategories()
	{
        $categoryDirector = $this->getDirector('design_category');
		
        $designCategoryLevel1 = $categoryDirector
            ->create()
            ->setName('design-category-level-1')
            ->setSlug('design-category-level-1')
            ->setEnabled(true)
            ->setRoot(true);

        $categoryDirector->save($designCategoryLevel1);
        $this->addReference('design-category-level-1', $designCategoryLevel1);

        /**
         * Category.
         *
         * @var CategoryInterface $category
         */
        $designCategoryLevel2 = $categoryDirector
            ->create()
            ->setName('design-category-level-2')
            ->setSlug('design-category-level-2')
            ->setEnabled(true)
            ->setParent($designCategoryLevel1)
            ->setRoot(false);

        $categoryDirector->save($designCategoryLevel2);
        $this->addReference('design-category-level-2', $designCategoryLevel2);

        /**
         * Second level category.
         *
         * @var CategoryInterface $secondLevelCategory
         */
        $designCategoryLevel3 = $categoryDirector
            ->create()
            ->setName('design-category-level-3')
            ->setSlug('design-category-level-3')
            ->setEnabled(true)
            ->setParent($designCategoryLevel2)
            ->setRoot(false);

        $categoryDirector->save($designCategoryLevel3);
        $this->addReference('design-category-level-3', $designCategoryLevel3);
	}
}
