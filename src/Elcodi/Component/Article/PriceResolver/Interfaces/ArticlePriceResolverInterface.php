<?php

namespace Elcodi\Component\Article\PriceResolver\Interfaces;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Interface ArticlePriceResolverInterface.
 */
interface ArticlePriceResolverInterface
{
    /**
     * Given an article, resolve the price.
     *
     * @param ArticleInterface $article
     * @param CurrencyInterface $currency
     *
     * @return Price
     */
    public function resolvePrice();
	
	public function getPrice(ArticleInterface $article, CurrencyInterface $currency);
	
	public function getReducedPrice(ArticleInterface $article, CurrencyInterface $currency);
}
