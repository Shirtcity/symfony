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
 * Class CategoryComponentController
 *
 * @Route(
 *      path = "",
 * )
 */
class DesignCategoryComponentController extends AbstractAdminController
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
     *      path = "/design-categories/component",
     *      name = "admin_design_category_list_component"
     * )
     * @Template("AdminCategoryBundle:DesignCategory:listComponent.html.twig")
     * @Method({"GET"})
     */
    public function listComponentAction()
    {
        $category_manager = $this->get('elcodi.provider.design_category_tree');
        $category_tree    = $category_manager->buildCategoryTree();

        return ['paginator' => $category_tree];
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
     *      path = "/design-category/{id}/component",
     *      name = "admin_design_category_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/design-category/new/component",
     *      name = "admin_design_category_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminCategoryBundle:DesignCategory:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.design_category",
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
     *      class = "elcodi_admin_article_form_type_design_category",
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

    /**
     * Sorts the categories with the given orders.
     *
     * @param Request $request The user request.
     *
     * @return array Result
     *
     * @Route(
     *      path = "/design-category/sort/component",
     *      name = "admin_design_category_sort_component",
     *      methods = {"POST"}
     * )
     *
     * @JsonResponse
     */
    public function sortComponentAction(Request $request)
    {
        $categoriesOrder = json_decode($request->get('data'), true);
		//die('<pre>' . var_export($categoriesOrder, true));
        if (!is_null($categoriesOrder)) {
            $orderResult = $this->get('elcodi_admin.category_sorter')
                ->sort($categoriesOrder);

            if ($orderResult) {
                return [
                    'result' => 'ok',
                ];
            }
        }

        return [
            'result'  => 'ko',
            'code'    => '400',
            'message' => 'Invalid order received',
        ];
    }
}
