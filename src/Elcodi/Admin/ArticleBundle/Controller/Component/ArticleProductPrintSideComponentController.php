<?php

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
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;

/**
 * Class ArticleProductPrintSideComponentController
 *
 * @Route(
 *      path = "article-product/{articleProductId}/article-product-print-side",
 *      requirements = {
 *          "articleProductId" = "\d+",
 *      }
 * )
 */
class ArticleProductPrintSideComponentController extends AbstractAdminController
{   
    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView         $formView Form view
     * @param ArticleProductInterface $articleProduct  ArticleProduct
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_article_product_print_side_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_article_product_print_side_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminArticleBundle:ArticleProductPrintSide:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.article_product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~articleProductId~"
     *      },
     *      name = "articleProduct"
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_article_product_print_sides",
     *      name  = "formView",
     *      entity = "articleProduct",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        ArticleProductInterface $articleProduct
    ) {
        return [
            'articleProduct' => $articleProduct,
            'form'			 => $formView,
        ];
    }
	
	
}
