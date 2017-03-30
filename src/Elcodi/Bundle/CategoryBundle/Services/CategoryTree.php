<?php

namespace Elcodi\Bundle\CategoryBundle\Services;

use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Bundle\CategoryBundle\Repository\CategoryRepository;

/**
 * Class CategoryTree.
 */
class CategoryTree
{
    /**
     * @var CategoryRepository
     *
     * Category repository
     */
    private $categoryRepository;

    /**
     * Construct method.
     *
     * @param CategoryRepository $categoryRepository Category Repository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Builds a category tree with all the categories and subcategories.
     *
     * cost O(n)
     *
     * @return array
     */
    public function buildCategoryTree()
    {
        $categories = $this
            ->categoryRepository
            ->getAllCategoriesSortedByParentAndPositionAsc();

        $categoryTree = [
            0 => null,
            'children' => [],
        ];

        /**
         * @var CategoryInterface $category
         */
        foreach ($categories as $category) {
            $parentCategoryId = 0;
            $categoryId = $category->getId();

            if (!$category->isRoot()) {
                if ($category->getParent() instanceof CategoryInterface) {
                    $parentCategoryId = $category->getParent()->getId();
                } else {

                    /**
                     * If category is not root and has no parent,
                     * don't insert it into the tree.
                     */
                    continue;
                }
            }

            if ($parentCategoryId && !isset($categoryTree[$parentCategoryId])) {
                $categoryTree[$parentCategoryId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            if (!isset($categoryTree[$categoryId])) {
                $categoryTree[$categoryId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            $categoryTree[$categoryId]['entity'] = $category;

            $categoryTree[$parentCategoryId]['children'][] = &$categoryTree[$categoryId];
        }

        return $categoryTree[0]['children']
            ?: [];
    }
}
