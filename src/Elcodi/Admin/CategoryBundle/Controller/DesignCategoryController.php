<?php

namespace Elcodi\Admin\CategoryBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;

/**
 * Class Controller for Design Category
 *
 * @Route(
 *      path = "",
 * )
 */
class DesignCategoryController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "/design-categories",
     *      name = "admin_design_category_list",
     *      methods = {"GET"}
     * )
     * @Template
     */
    public function listAction()
    {
        return [];
    }

    /**
     * Edit and Saves Design category
     *
     * @param FormInterface     $form     Form
     * @param CategoryInterface $category DesignCategory
     * @param boolean           $isValid  Is valid
     * @param Request           $request  Request
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/design-category/{id}",
     *      name = "admin_design_category_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/design-category/{id}/update",
     *      name = "admin_design_category_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/design-category/new",
     *      name = "admin_design_category_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/design-category/new/update",
     *      name = "admin_design_category_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.design_category",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "category",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_design_category",
     *      name  = "form",
     *      entity = "category",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        CategoryInterface $category,
        $isValid,
        Request $request
    ) {	
        if ($isValid) {
            $this->flush($category);

            $this->addFlash('success', 'admin.category.saved');

            if ($request->query->get('modal', false)) {
                $redirection = $this->redirectToRoute(
                    'admin_design_category_edit',
                    ['id' => $category->getId()]
                );
            } else {
                $redirection = $this->redirectToRoute('admin_design_category_list');
            }

            return $redirection;
        }
		
        return [
            'category' => $category,
            'form'     => $form->createView(),
        ];
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/design-category/{id}/enable",
     *      name = "admin_design_category_enable",
     *      methods = {"GET", "POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return parent::enableAction(
            $request,
            $entity
        );
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/design-category/{id}/disable",
     *      name = "admin_design_category_disable",
     *      methods = {"GET", "POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    ) {
        return parent::disableAction(
            $request,
            $entity
        );
    }

    /**
     * Delete entity
     *
     * @param Request $request      Request
     * @param mixed   $entity       Entity to delete
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/design-category/{id}/delete",
     *      name = "admin_design_category_delete",
     *      methods = {"GET", "POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design_category.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectPath = null
    ) {
        return parent::deleteAction(
            $request,
            $entity,
            $this->generateUrl('admin_design_category_list')
        );
    }
}
