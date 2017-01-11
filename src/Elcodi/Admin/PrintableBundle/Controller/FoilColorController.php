<?php

namespace Elcodi\Admin\PrintableBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FoilColorInterface;

/**
 * Class Controller for FoilColor
 *
 * @Route(
 *      path = "/foilcolor",
 * )
 */
class FoilColorController extends AbstractAdminController
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
     *      name = "admin_foilcolor_list",
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
     * @Template("AdminPrintableBundle:foilcolor:list.html.twig")
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
     * Edit and Saves page
     *
     * @param FormInterface   $form    Form
     * @param FoilColorInterface $foilcolor  FoilColor
     * @param boolean         $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_foilcolor_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_foilcolor_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_foilcolor_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_foilcolor_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.foilcolor",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "foilcolor",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_printable_form_type_foilcolor",
     *      name  = "form",
     *      entity = "foilcolor",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template("AdminPrintableBundle:foilcolor:edit.html.twig")
     */
    public function editAction(
        FormInterface $form,
        FoilColorInterface $foilcolor,
        $isValid
    ) {

        if ($isValid) {
            $this->flush($foilcolor);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.foilcolor.saved')
            );

            return $this->redirectToRoute('admin_foilcolor_list');
        }

        return [
            'foilcolor' => $foilcolor,
            'form'    => $form->createView()
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
     *      path = "/{id}/enable",
     *      name = "admin_foilcolor_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.foilcolor.class",
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
     *      path = "/{id}/disable",
     *      name = "admin_foilcolor_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.foilcolor.class",
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
     *      path = "/{id}/delete",
     *      name = "admin_foilcolor_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.foilcolor.class",
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
            $this->generateUrl('admin_foilcolor_list')
        );
    }
}
