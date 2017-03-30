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

namespace Elcodi\Admin\ProductBundle\Controller\Component;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Bundle\ProductBundle\Entity\Product;

/**
 * Class PrintSideComponentController
 *
 * @Route(
 *      path = "print_side"
 * )
 */
class PrintSideComponentController extends AbstractAdminController
{
    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView         $formView Form view
     * @param Product		   $product  Product
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_product_print_side_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
	 * 
     * @Template("AdminProductBundle:PrintSide:editComponent.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_print_side_form_type_product",
     *      name  = "formView",
     *      entity = "product",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        Product $product
    ) {
        return [
            'product'  => $product,
            'form'     => $formView,
        ];
    }
}
