<?php

namespace Elcodi\Component\Article\Validator;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class ArticleProductColorValidator.
 *
 * Api Methods:
 *
 * * validateArticleProductColor(ArticleInterface)
 *
 * @api
 */
class ArticleProductColorValidator
{
    /**
     * When a cart goes below 0 (due to discounts), set the amount to 0.
     *
     * @param CartInterface $cart Cart
     */
    public function validateArticleProductColor(ArticleInterface $article)
    {
        $product = $article->getArticleProduct()->getProduct();
		$productColor = $article->getArticleProduct()->getProductColors();
				
		if(null === $productColor){
			return;
		}
		
		$availableProductColors = $product->getColors();
		$articleProductColorIsAvailable = $availableProductColors->contains($productColor);
		
		if( false === $articleProductColorIsAvailable) {
			$productColor = $availableProductColors->first();
			$article->getArticleProduct()->setProductColors($productColor);
		}
    }

    
}
