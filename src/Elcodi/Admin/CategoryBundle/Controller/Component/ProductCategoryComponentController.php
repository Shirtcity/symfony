<?php

namespace Elcodi\Admin\CategoryBundle\Controller\Component;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;

/**
 * Class ProductCategoryComponentController
 *
 * @Route(
 *      path = "",
 * )
 */
class ProductCategoryComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "/product-categories/component",
     *      name = "admin_product_category_list_component"
     * )
     * @Template("AdminCategoryBundle:ProductCategory:listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $repository = $this->get('elcodi.repository.product_category');
        $categories    = $repository->findAll();

        return ['paginator' => $categories];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView          $formView Form view
     * @param CategoryInterface $category Category
     *
     * @return array Result
     *
     * @Route(
     *      path = "/product-category/{id}/component",
     *      name = "admin_product_category_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/product-category/new/component",
     *      name = "admin_product_category_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminCategoryBundle:ProductCategory:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product_category",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "category",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_product_category",
     *      name  = "formView",
     *      entity = "category",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        CategoryInterface $category
    ) {		
        return [
            'category' => $category,
            'form'     => $formView,
        ];
    }    
}
