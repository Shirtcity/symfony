<?php

namespace Elcodi\Admin\ProductBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;

use Elcodi\Bundle\ProductBundle\Entity\ProductSize;

/**
 * Class Controller for ProductSize
 *
 * @Route(
 *      path = "/product/size",
 * )
 */
class ProductSizeController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_product_size_list",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }
	
	/**
     * Edit and Saves product size
     *
     * @param FormInterface    $form    Form
     * @param ProductSize	   $productSize ProductSize
     * @param boolean          $isValid Is valid
     * @param Request          $request      Request
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_product_size_view",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_product_size_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_product_size_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_product_size_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_product_size_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product_size",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "productSize",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_size_form_type",
     *      name  = "form",
     *      entity = "productSize",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        ProductSize $productSize,
        $isValid,
        Request $request
    ) {
        if ($isValid) {
			
            $this->flush($productSize);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.product_size.saved')
            );
            
            if ($request->query->get('modal', false)) {
                $redirection = $this
                    ->redirectToRoute(
                        'admin_product_size_edit',
                        ['id' => $productSize->getId()]
                    );
            } else {
                $redirection = $this->redirectToRoute('admin_product_size_list');
            }
        }

        return [
            'productSize' => $productSize,
            'form'    => $form->createView(),
        ];
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
     *      path = "/{id}/delete",
     *      name = "admin_product_size_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.product_size.class",
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
            $this->generateUrl('admin_product_size_list')
        );
    }
}
