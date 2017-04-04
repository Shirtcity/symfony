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
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Bundle\ProductBundle\Entity\Product;

/**
 * Class Controller for PrintSide
 *
 * @Route(
 *      path = "/print_side",
 * )
 */
class PrintSideController extends AbstractAdminController
{   
	
	/**
     * Edit and Saves product
     *
     * @param FormInterface    $form    Form
     * @param Product		   $product Product
     * @param boolean          $isValid Is valid
     *
     * @return RedirectResponse Redirect response
	 * 
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_print_side_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_print_side_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "product",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product_print_side",
     *      name  = "form",
     *      entity = "product",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        Product $product,
        $isValid
    ) {
		
        if ($isValid) {
			
            $this->flush($product);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.product.saved')
            );
			
            return $this->redirectToRoute('admin_print_side_edit', ['id' => $product->getId()]);
        }

        return [
            'product' => $product,
            'form'    => $form->createView(),
        ];
    }
}
