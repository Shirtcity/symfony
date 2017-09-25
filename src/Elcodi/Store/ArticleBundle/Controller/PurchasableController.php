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

namespace Elcodi\Store\ArticleBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

use Symfony\Component\Form\FormInterface;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Store\CoreBundle\Controller\Traits\TemplateRenderTrait;

/**
 * Article related actions
 */
class PurchasableController extends Controller
{
    use TemplateRenderTrait;

    /**
     * Purchasable related view
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return array
     *
     * @throws EntityNotFoundException Purchasable not found
     *
     * @Route(
     *      path = "/purchasable/{id}/related",
     *      name = "store_purchasable_related",
     *      requirements = {
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
     */
    public function relatedAction($id)
    {
        $purchasable = $this
            ->get('elcodi.repository.purchasable')
            ->find($id);

        if (!$purchasable instanceof PurchasableInterface) {
            throw new EntityNotFoundException('Purchasable not found');
        }

        $relatedArticles = $this
            ->get('elcodi.related_purchasables_provider')
            ->getRelatedPurchasables($purchasable, 3);

        return $this->renderTemplate('Modules:_purchasable-related.html.twig', [
            'purchasables' => $relatedArticles,
        ]);
    }

    /**
     * Purchasable view
     *
     * @param integer $id   Purchasable id
     * @param string  $slug Article slug
     *
     * @return array
     *
     * @throws EntityNotFoundException Purchasable not found
     *
     * @Route(
     *      path = "/{slug}-{id}",
     *      name = "store_article_view",
     *      requirements = {
     *          "slug": "(.*)",
     *          "id": "\d+",
     *      },
     *      methods = {"GET"}
     * )
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
     *      class = "elcodi_store_article_simple_form_type_article",
     *      name  = "form",
     *      entity = "article",
     *      handleRequest = true
     * )
     */
    public function viewAction(
        FormInterface $form,
        $id,
        $slug
    ) {
        $purchasable = $this
            ->get('elcodi.repository.purchasable')
            ->find($id);

        if (!$purchasable instanceof PurchasableInterface) {
            throw new EntityNotFoundException('Purchasable not found');
        }

        /**
         * We must check that the purchasable slug is right. Otherwise we must
         * return a Redirection 301 to the right url
         */
        /*if ($slug !== $purchasable->getSlug()) {
            $route = $this
                ->get('request_stack')
                ->getCurrentRequest()
                ->get('_route');

            return $this->redirectToRoute($route, [
                'id'   => $purchasable->getId(),
                'slug' => $purchasable->getSlug(),
            ], 301);
        }*/


        $template = $this->resolveTemplateName($purchasable);
        $variableName = $this->resolveVariableName($purchasable);
        
        return $this->renderTemplate($template, [
            $variableName   => $purchasable,
            'form'          => $form->createView(),
        ]);
    }

    /**
     * Resolve view given the purchasable instance
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return string template name
     */
    private function resolveTemplateName(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ArticleInterface) {
            return 'Pages:article-view-item.html.twig';
        }

        return '';
    }

    /**
     * Resolve the variable name given the purchasable instance
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return string variable name
     */
    private function resolveVariableName(PurchasableInterface $purchasable)
    {
        if ($purchasable instanceof ArticleInterface) {
            return 'article';
        }

        return '';
    }
}
