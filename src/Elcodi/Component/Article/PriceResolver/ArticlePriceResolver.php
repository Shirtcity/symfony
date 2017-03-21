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

namespace Elcodi\Component\Article\PriceResolver;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Article\PriceResolver\Interfaces\ArticlePriceResolverInterface;
use \Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class ArticleNameResolver.
 */
class ArticlePriceResolver extends ContainerAware implements ArticlePriceResolverInterface 
{   
	private $article;
    private $currency;
	
    /**
     * Given an article, resolve the price.
     *
     * @param ArticleInterface $article
     * @param CurrencyInterface $currency
     *
     * @return Price
     */
    public function resolvePrice() 
	{        
		if(is_null($this->currency)) {
			$this->currency = $this->container->get('elcodi.store')->getDefaultCurrency();
		}
		
		$product = $this->article->getArticleProduct()->getProduct();
		$currency = $this->currency;
		
		return $product->getPrices()->filter(
			function($entry) use ($currency) {
			   return $entry->getCurrency() == $currency;
			}
		)->first(); 
    }

	/**
	 * Get article price
	 * 
	 * @return Price
	 */
	public function getPrice(ArticleInterface $article, CurrencyInterface $currency = null)
	{
		$this->article = $article;
        $this->currency = $currency;
		
		return $this->resolvePrice();
	}
	
	
	/**
	 * Get article reduced price
	 * 
	 * @return Price
	 */
	public function getReducedPrice(ArticleInterface $article, CurrencyInterface $currency = null)
	{
		$this->article = $article;
        $this->currency = $currency;
		
		return null;
	}
}
