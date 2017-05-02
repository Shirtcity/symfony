<?php

namespace Elcodi\Component\Article\Services;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;


class ArticleProductColorResolver
{
	/**
	 * @var ArticleProductInterface 
	 * 
	 * ArticleProduct
	 */
	private $articleProduct;

	/**
	 * Resolves product color
	 * 
	 * @param ArticleProductInterface $articleProduct
	 */
    public function resolveArticleProductColor(ArticleProductInterface $articleProduct)
	{
		$this->articleProduct = $articleProduct;
				
		if(null === $articleProduct->getProductColors()){
			return;
		}		
		
		if( false === $this->isCurrentColorAvailable()) {			
			$this->setDefaultProductColor();
		}
	}
	
	/**
	 * Checks if the current product color is available for new selected product
	 */
	private function isCurrentColorAvailable()
	{
		$currentColor = $this->articleProduct
			->getProductColors()
			->getColor();
		
		return $this->articleProduct
			->getProduct()
			->getColors()
			->exists(function($id, $availableProductColor) use ($currentColor){
				return $availableProductColor->getColor() == $currentColor;
			});
	}
	
	/**
	 * Sets default color for article product
	 */
	private function setDefaultProductColor()
	{
		$productColors = $this->articleProduct
			->getProduct()
			->getColors()
			->first();
			
		$this->articleProduct->setProductColors($productColors);
	}
}
