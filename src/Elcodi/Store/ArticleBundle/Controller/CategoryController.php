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

namespace Elcodi\Store\ArticleBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as AnnotationEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Bundle\CategoryBundle\Repository\CategoryRepository;
use Elcodi\Component\Article\Repository\PurchasableRepository;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Category controller
 *
 * @Route(
 *      path = ""
 * )
 */
class CategoryController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Renders the category nav component
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/categories/nav",
     *      name = "store_categories_nav",
     *      methods = {"GET"}
     * )
     */
    public function navAction()
    {
        $masterRequest = $this
            ->get('request_stack')
            ->getMasterRequest();

        $currentCategory = $this->getCurrentCategoryGivenRequest($masterRequest);

        $categoryTree = $this
            ->get('elcodi_store.store_category_tree')
            ->load();
	
        return $this->renderTemplate(
            'Subpages:category-nav.html.twig',
            [
                'currentCategory' => $currentCategory,
                'categoryTree'    => $categoryTree,
            ]
        );
    }

    /**
     * Render all category purchasables
     *
     * @param CategoryInterface $category Category
     *
     * @return Response Response
     *
     * @Route(
     *      path = "category/{slug}/{id}",
     *      name = "store_category_purchasables_list",
     *      requirements = {
     *          "slug" = "[a-zA-Z0-9-]+",
     *          "id" = "\d+"
     *      },
     *      methods = {"GET"}
     * )
     *
     * @AnnotationEntity(
     *      class = "elcodi.entity.section_category.class",
     *      name = "category",
     *      mapping = {
     *          "id" = "~id~",
     *          "enabled" = true,
     *      }
     * )
     */
    public function viewAction(CategoryInterface $category, $slug)
    {
        /**
         * We must check that the article slug is right. Otherwise we must
         * return a Redirection 301 to the right url
         */
        if ($slug !== $category->getSlug()) {
            return $this->redirectToRoute('store_category_purchasables_list', [
                'id'   => $category->getId(),
                'slug' => $category->getSlug(),
            ], 301);
        }

        /**
         * @var CategoryRepository $categoryRepository
         * @var PurchasableRepository $articleRepository
         */		
        $categoryRepository = $this->get('elcodi.repository.category');
        $articleRepository = $this->get('elcodi.repository.article');

        $categories = array_merge(
            [$category],
            $categoryRepository->getChildrenCategories($category)
        );

        $purchasables = $articleRepository->getAllFromCategories($categories);

        return $this->renderTemplate(
            'Pages:category-view.html.twig',
            [
                'purchasables' => $purchasables,
                'category' => $category,
            ]
        );
    }

    /**
     * Given a request, return the current highlight-able category
     *
     * @param Request $request Request
     *
     * @return CategoryInterface|null
     */
    protected function getCurrentCategoryGivenRequest(Request $request)
    {
        $masterRoute = $request->get('_route');
        $category = null;

        /**
         * @var CategoryInterface $category
         * @var PurchasableInterface $purchasable
         */
        if ($masterRoute === 'store_purchasable_view') {
            $purchasableId = $request->get('id');
            $articleRepository = $this->get('elcodi.repository.purchasable');

            $purchasable = $articleRepository->find($purchasableId);
            $category = $purchasable->getPrincipalCategory();
        } elseif ($masterRoute === 'store_category_purchasables_list') {
            $categoryId = $request->get('id');
            $categoryRepository = $this->get('elcodi.repository.category');
            $category = $categoryRepository->find($categoryId);
        }

        return $category;
    }
}
