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

namespace Elcodi\Bundle\CategoryBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryRepositoryTest.
 */
class RootCategoryEventListenerTest extends WebTestCase
{
    /**
     * @var ObjectDirector
     *
     * The section category director.
     */
    protected $sectionCategoryDirector;
	
	/**
     * @var ObjectDirector
     *
     * The design category director.
     */
    protected $designCategoryDirector;

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->sectionCategoryDirector = $this->get('elcodi.director.section_category');
		$this->designCategoryDirector = $this->get('elcodi.director.design_category');
    }

    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiArticleBundle',
        ];
    }

    /**
     * Test that creating a new section category the parent category should be null.
     */
    public function testNewSectionCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->sectionCategoryDirector
            ->findOneBy(['slug' => 'section-category']);

        $category = $this->sectionCategoryDirector->create();
        $category->setRoot(true);
        $category->setParent($rootCategory);
        $category->setName('New section category');
        $category->setSlug('new-section-category');

        $this
            ->sectionCategoryDirector
            ->save($category);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->sectionCategoryDirector
            ->findOneBy(['slug' => 'new-section-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }

    /**
     * Test that modifying a new category the parent category should be
     * null.
     */
    public function testEditSectionCategoryIsSavedWithParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->sectionCategoryDirector
            ->findOneBy(['slug' => 'section-category']);

        /**
         * @var $anotherCategory CategoryInterface
         */
        $anotherCategory = $this
            ->sectionCategoryDirector
            ->findOneBy(['slug' => 'category']);

        $rootCategory->setParent($anotherCategory);

        $this
            ->sectionCategoryDirector
            ->save($rootCategory);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->sectionCategoryDirector
            ->findOneBy(['slug' => 'section-category']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }
	
	/**
     * Test that creating a new section category the parent category should be null.
     */
    public function testDesignCategoryIsSavedWithoutParent()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-1']);

        $category = $this->designCategoryDirector->create();
        $category->setRoot(true);
        $category->setParent($rootCategory);
        $category->setName('New design category level 1');
        $category->setSlug('new-design-category-level-1');

        $this
            ->designCategoryDirector
            ->save($category);

        /**
         * @var $category CategoryInterface
         */
        $category = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'new-design-category-level-1']);

        $this->assertNull(
            $category->getParent(),
            'The parent for a root category should always be null'
        );
    }
	
	/**
     * Test that creating a new section category the parent category should be null.
     */
    public function testDesignCategoriesAreSavedWithParent()
    {
        $designCategoryLevel1 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-1']);
		
        $designCategoryLevel2 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-2']);		
		
        $designCategoryLevel3 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-3']);
		
        $designCategoryLevel2->setParent($designCategoryLevel1);
		$designCategoryLevel3->setParent($designCategoryLevel2);

        $this
            ->designCategoryDirector
            ->save($designCategoryLevel2);
		
		$this
            ->designCategoryDirector
            ->save($designCategoryLevel3);

        /**
         * @var $category CategoryInterface
         */
        $designCategoryLevel1 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-1']);

        $this->assertNull(
            $designCategoryLevel1->getParent(),
            'The parent for a root category should always be null'
        );
		
		$designCategoryLevel2 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-2']);

        $this->assertEquals(
            $designCategoryLevel2->getParent(),
            $designCategoryLevel1
        );
		
		$designCategoryLevel3 = $this
            ->designCategoryDirector
            ->findOneBy(['slug' => 'design-category-level-3']);
		
		$this->assertEquals(
            $designCategoryLevel3->getParent(),
            $designCategoryLevel2
        );
    }
}
