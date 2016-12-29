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

namespace Elcodi\Admin\ArticleBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\VariantInterface;

/**
 * Class VariantComponentController
 *
 * @Route(
 *      path = "article/{articleId}/variant",
 *      requirements = {
 *          "articleId" = "\d+",
 *      }
 * )
 */
class VariantComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator $paginator Paginator instance
     * @param integer   $articleId Article id
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/component",
     *      name = "admin_article_variant_list_component"
     * )
     * @Template("AdminArticleBundle:Variant:listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      class = "elcodi.entity.article_variant.class",
     *      innerJoins = {
     *          {"x", "article", "p", false}
     *      },
     *      wheres = {
     *          {"p", "id", "=", "~articleId~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        $articleId
    ) {
        return [
            'paginator' => $paginator,
            'articleId' => $articleId,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView         $formView Form view
     * @param ArticleInterface $article  Article
     * @param VariantInterface $variant  Variant
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_article_variant_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_article_variant_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminArticleBundle:Variant:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.article",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~articleId~"
     *      },
     *      name = "article"
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.article_variant",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "variant",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_article_variant",
     *      name  = "formView",
     *      entity = "variant",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        ArticleInterface $article,
        VariantInterface $variant
    ) {
        $useStock = $this
            ->get('elcodi.store')
            ->getUseStock();

        return [
            'variant'  => $variant,
            'article'  => $article,
            'form'     => $formView,
            'useStock' => $useStock,
        ];
    }
}
