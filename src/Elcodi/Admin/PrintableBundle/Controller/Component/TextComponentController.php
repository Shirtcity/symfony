<?php

namespace Elcodi\Admin\PrintableBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextInterface;

/**
 * Class TextComponentController
 *
 * @Route(
 *      path = "/text"
 * )
 */
class TextComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_text_list_component",
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
     *      methods = {"GET"}
     * )
     *
     * @Template("AdminPrintableBundle:text:listComponent.html.twig")
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.entity.text.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param TextInterface $text   Entity
     * @param FormView        $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_text_edit_component",
     *       requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_text_new_component",
     *      methods = {"GET"}
     * )
     *
     * @Template("AdminPrintableBundle:text:editComponent.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.text",
     *      },
     *      name = "text",
     *      mapping = {
     *          "id": "~id~",
     *      },
     *      mappingFallback = true,
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_printable_form_type_text",
     *      name  = "formView",
     *      entity = "text"
     * )
     */
    public function editComponentAction(
        TextInterface $text,
        FormView $formView
    ) {

        return [
            'text' => $text,
            'form'   => $formView,
        ];
    }
}
