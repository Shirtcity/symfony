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
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignInterface;

/**
 * Class Controller for Design
 *
 * @Route(
 *      path = "/design",
 * )
 */
class DesignController extends AbstractAdminController
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
     *      name = "admin_design_list",
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
     * @Template("AdminPrintableBundle:design:list.html.twig")
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
     * @param DesignInterface $design  Design
     * @param boolean         $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_design_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_design_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_design_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_design_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.design",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "design",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_printable_form_type_design",
     *      name  = "form",
     *      entity = "design",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template("AdminPrintableBundle:design:edit.html.twig")
     */
    public function editAction(
        FormInterface $form,
        DesignInterface $design,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($design);

            //Save the file in the entity
            $design->setUpdatedAt( new \DateTime('now') );
            $this->flush($design);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.design.saved')
            );

            return $this->redirectToRoute('admin_design_list');
        }


        return [
            'design' => $design,
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
     *      name = "admin_design_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design.class",
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
     *      name = "admin_design_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design.class",
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
     *      name = "admin_design_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design.class",
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
            $this->generateUrl('admin_design_list')
        );
    }

    /**
     * Download design preview
     *
     * @param DesignInterface $design  Design
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/download/preview/{level_1}/{level_2}/{level_3}/{previewFileName}",
     *      name = "admin_design_download_preview",
     *      requirements = {
     *          "level_1" = "\d+",
     *          "level_2" = "\d+",
     *          "level_3" = "\d+",
     *      },
     * )
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design.class",
     *      mapping = {
     *          "previewFileName" = "~previewFileName~"
     *      }
     * )
     */
    public function downloadPreviewAction(
        Request $request,
        $entity
    ) {
        $downloadHandler = $this->get('vich_uploader.download_handler');
        return $downloadHandler->downloadObject($entity, $fileField = 'previewFile');
    }

    /**
     * Download design vector
     *
     * @param DesignInterface $desgn  Design
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/download/vector/{level_1}/{level_2}/{level_3}/{vectorFileName}",
     *      name = "admin_design_download_vector",
     *      requirements = {
     *          "level_1" = "\d+",
     *          "level_2" = "\d+",
     *          "level_3" = "\d+",
     *      },
     * )
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.design.class",
     *      mapping = {
     *          "vectorFileName" = "~vectorFileName~"
     *      }
     * )
     */
    public function downloadVectorAction(
        Request $request,
        $entity
    ) {
        $downloadHandler = $this->get('vich_uploader.download_handler');
        return $downloadHandler->downloadObject($entity, $fileField = 'vectorFile');
    }
}
