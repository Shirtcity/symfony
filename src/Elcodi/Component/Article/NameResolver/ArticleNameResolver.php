<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Article\NameResolver;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\NameResolver\Interfaces\PurchasableNameResolverInterface;

/**
 * Class ArticleNameResolver.
 */
class ArticleNameResolver implements PurchasableNameResolverInterface
{
    /**
     * @var PurchasableInterface 
     * 
     * Article
     */
    private $article;
    
    /**
     * @var string
     *
     * Name separator
     */
    private $separator;
    
    /**
     * @var string
     * 
     * Article name 
     */
    private $articleName;
    
    /**
     * Get the entity interface.
     *
     * @return string Namespace
     */
    public function getPurchasableNamespace()
    {
        return 'Elcodi\Component\Article\Entity\Interfaces\ArticleInterface';
    }

    /**
     * Given an article, resolve the name.
     *
     * @param PurchasableInterface  $article    Article
     * @param string                $separator  Separator
     *
     * @return false|string Name resolved or false if invalid object
     */
    public function resolveName(
        PurchasableInterface $article,
        $separator = self::DEFAULT_SEPARATOR
    ) {
        
        $namespace = $this->getPurchasableNamespace();
        if (!$article instanceof $namespace) {
            return false;
        }
        
        $this->separator = $separator;
        $this->article = $article;
        
        if (!empty($this->article->getName())) {
            
            $this->articleName = $this->article->getName();
            
        } else {
            
            $this
                ->obtainArticleDesignsNames()
                ->addProductName();
            
        }
        
        return $this->articleName;
    }

    /**
     * Obtains designs names from the first not empty printable area of an article
     * 
     * @return string
     */
    private function obtainArticleDesignsNames()
    {
        $designName = null;
        
        $this
            ->article
            ->getArticleProduct()
            ->getArticleProductPrintSides()
            ->filter( function ($articleProductPrintSide) {
                
                return $articleProductPrintSide->getPrintableVariants()->count() > 0;
                
            })
            ->first()
            ->getPrintableVariants()
            ->map( function ($printableVariant) use (&$designName) {  
                
                if ($printableVariant->getType() == 'DesignVariant') {
                    $designName .= $printableVariant->getDesign()->getName() . $this->separator;
                } 
                
            });
        
        $this->articleName = $designName;
        
        return $this;
    }
    
    private function addProductName()
    {
        $this->articleName .= $this
            ->article
            ->getArticleProduct()
            ->getProduct()
            ->getName();
        
        return $this;
    }
}
