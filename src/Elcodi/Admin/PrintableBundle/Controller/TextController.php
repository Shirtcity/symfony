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
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextInterface;

use Elcodi\Bundle\PrintableBundle\Entity\Text;
use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;

use Elcodi\Bundle\PrintableBundle\Entity\Photo;
use Elcodi\Bundle\PrintableBundle\Entity\PhotoVariant;


use Elcodi\Bundle\PrintableBundle\Entity\Design;
use Elcodi\Bundle\PrintableBundle\Entity\DesignVariant;

use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;
/**
 * Class Controller for Text
 *
 * @Route(
 *      path = "/text",
 * )
 */
class TextController extends AbstractAdminController
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
     *      name = "admin_text_list",
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
     * @Template("AdminPrintableBundle:text:list.html.twig")
     * @Method({"GET"})
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {

        $em = $this->getDoctrine()->getManager();

       // $variant = $em->find('Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant', 7);
        //var_dump($variant);

/*

        $myText = $em ->find('Elcodi\Bundle\PrintableBundle\Entity\Text', 9);
        $myDesign = $em ->find('Elcodi\Bundle\PrintableBundle\Entity\Design', 1);
        $myPhoto = $em ->find('Elcodi\Bundle\PrintableBundle\Entity\Photo', 1);

        $textvariant = new TextVariant();
        $textvariant->setPosX(1)->setPosY(2)->setText( $myText);
        $em->persist($textvariant);
        $em->flush();

        $designvariant = new DesignVariant();
        $designvariant->setPosX(3)->setPosY(4)->setDesign( $myDesign);
        $em->persist($designvariant);
        $em->flush();

        $photovariant = new PhotoVariant();
        $photovariant->setPosX(5)->setPosY(6)->setPhoto( $myPhoto);
        $em->persist($photovariant);
        $em->flush();


*/



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
     * @param TextInterface $text  Text
     * @param boolean         $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_text_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_text_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_text_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_text_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.text",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "text",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_printable_form_type_text",
     *      name  = "form",
     *      entity = "text",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template("AdminPrintableBundle:text:edit.html.twig")
     */
    public function editAction(
        FormInterface $form,
        TextInterface $text,
        $isValid
    ) {

        if ($isValid) {
            $this->flush($text);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.text.saved')
            );

            return $this->redirectToRoute('admin_text_list');
        }

        return [
            'text' => $text,
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
     *      name = "admin_text_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.text.class",
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
     *      name = "admin_text_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.text.class",
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
     *      name = "admin_text_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.text.class",
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
            $this->generateUrl('admin_text_list')
        );
    }
}
