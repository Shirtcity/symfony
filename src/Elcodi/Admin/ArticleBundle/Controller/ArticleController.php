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

namespace Elcodi\Admin\ArticleBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Elcodi\Admin\CoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Controller for Article
 *
 * @Route(
 *      path = "/article",
 * )
 */
class ArticleController extends AbstractAdminController
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
     *      name = "admin_article_list",
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
     * Edit and Saves article
     *
     * @param FormInterface    $form    Form
     * @param ArticleInterface $article Article
     * @param boolean          $isValid Is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_article_view",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_article_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_article_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_article_new",
     *      methods = {"GET"}
     * )
     * @Route(
     *      path = "/new/update",
     *      name = "admin_article_save",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.wrapper.article",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      name = "article",
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_article_form_type_article",
     *      name  = "form",
     *      entity = "article",
     *      handleRequest = true
     * )
     *
     * @Template
     */
    public function editAction(
        FormInterface $form,
        ArticleInterface $article,
        Request $request
    ) {	
       
       /*foreach ($form->getErrors(true) as $key => $error) {
	//echo $error->getMessage();
         //  var_dump($error);
}*/
        $validator = $this->get('validator');
        $errors = $validator->validate($article);
        
        die(var_dump($validator));
        
        $articleProductPrintSide = $article
            ->getArticleProduct()
            ->getArticleProductPrintSides()
            ->first();
        
        $printableVariantDesign = $articleProductPrintSide
            ->getDesignPrintableVariants()
            ->first();
        
        $printSideArea = $article->getArticleProduct()
            ->getArticleProductPrintSides()
            ->first()
            ->getPrintSide()
            ->getAreas()
            ->first();
        
        $printSideAreaPosX = $printSideArea->getPosX();
        $printSideAreaPosY = $printSideArea->getPosY();
        $printSideAreaWidth = $printSideArea->getWidth();
        $printSideAreaHeight = $printSideArea->getHeight();
        
        // Invalid data
        $invalidPosX = $printSideAreaPosX - 5000;
        $invalidPosY = $printSideAreaPosX - 5000;
        $invalidWidth = $printSideAreaWidth + 5000;
        $invalidHeight = $printSideAreaHeight + 50000; 

        // valid data test
        $printableVariantDesign
			->setPosX($invalidPosX)
			->setPosY($invalidPosY)
            ->setWidth($invalidWidth);
        
        $errors = $validator->validate($article);
        
        die(var_dump(count($errors)));
		if ($form->isValid() && !$request->isXmlHttpRequest()) {	
            
            // delete disabled print sides
            // @TODO: move to doctrine preFlush event listener?
            $articleProductPrintSides = $article->getArticleProduct()->getArticleProductPrintSides();
            
            foreach ($articleProductPrintSides as $articleProductPrintSide) {
                if ($articleProductPrintSide->isEnabled() === false) {
                    $article->getArticleProduct()->removeArticleProductPrintSide($articleProductPrintSide);
                }
            }
		
            $this->flush($article);

            $this->addFlash(
                'success',
                $this
                    ->get('translator')
                    ->trans('admin.article.saved')
            );
			
			return $this->redirectToRoute('admin_article_list');
        }
        
        return [
            'article' => $article,
            'form'    => $form->createView(),
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
     *      name = "admin_article_enable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.article.class",
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
     *      name = "admin_article_disable"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.article.class",
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
     *      name = "admin_article_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.entity.article.class",
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
            $this->generateUrl('admin_article_list')
        );
    }	
}
