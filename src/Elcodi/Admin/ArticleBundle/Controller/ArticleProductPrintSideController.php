<?php

namespace Elcodi\Admin\ArticleBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;

/**
 * Class Controller for ArticleProductPrintSide
 *
 * @Route(
 *      path = "/article-product/{articleProductId}/article-product-print-side",
 *      requirements = {
 *          "articleProductId" = "\d+",
 *      }
 * )
 */
class ArticleProductPrintSideController extends AbstractAdminController
{	
    /**
     * Edit and Saves article
     *
     * @param FormInterface    $form    Form
     * @param ArticleProductInterface $articleProduct ArticleProduct
     * @param boolean          $isValid Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/edit",
     *      name = "admin_article_product_print_side_edit",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/update",
     *      name = "admin_article_product_print_side_update",
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_article_product_print_side_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_article_product_print_side_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.article_product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~articleProductId~"
     *      },
     *      name = "articleProduct"
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_article_product_print_sides",
     *      name  = "form",
     *      entity = "articleProduct",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        ArticleProductInterface $articleProduct,
        $isValid
    ) {
        if ($isValid) {
			
            $this->flush($articleProduct);

            $this->addFlash('success', 'admin.articleProductPrintSide.saved');

            return $this->redirectToRoute('admin_article_product_print_side_edit', [
                'articleProductId' => $articleProduct->getId(),
            ]);
        }

        return [
            'articleProduct' => $articleProduct,
            'form'    => $form->createView(),
        ];
    }

    

    /**
     * Delete element action
     *
     * @param Request $request      Request
     * @param mixed   $articleProduct ArticleProduct
     * @param string  $redirectPath Redirect path
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/delete",
     *      name = "admin_article_product_print_side_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *     class = "elcodi.entity.article_product.class",
     *     name = "articleProduct",
     *     mapping = {
     *         "id": "~articleProductId~"
     *     }
     * )
     */
    public function deleteAction(
        Request $request,
        $articleProduct,
        $redirectPath = null
    ) {
        $articleProductPrintSides = $articleProduct->getArticleProductPrintSides();        
		
		foreach ($articleProductPrintSides as $articleProductPrintSide) {
			$articleProduct->removeArticleProductPrintSide($articleProductPrintSide);
		}

        $this->flush($articleProduct);

		$redirectUrl = $request->headers->get('referer');
		
        return $this->redirect($redirectUrl);
    }    
}
