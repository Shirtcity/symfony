<?php

namespace Elcodi\Component\Article\ImageResolver;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;
use Elcodi\Component\Article\ImageResolver\Interfaces\ArticleImageResolverInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

/**
 * Class ArticleImageResolver.
 */
class ArticleImageResolver extends AbstractImageResolverWithImageResolver implements ArticleImageResolverInterface
{
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
     * Get valid Image.
     *
     * @param PurchasableInterface $purchasable Purchasable
     *
     * @return ImageInterface|false Image resolved
     */
    public function getValidImage(PurchasableInterface $purchasable)
    {
        $namespace = $this->getPurchasableNamespace();
        if (!$purchasable instanceof $namespace) {
            return false;
        }
		
        /**
         * @var ArticleInterface $purchasable
         */
        return $this
            ->imageResolver
            ->resolveImage($purchasable);
    }
	
	/**
	 * Get article preview
	 * 
	 * @param ArticleInterface $article
	 */
	public function getPreviewImages(ArticleInterface $article) 
	{
		if(null === $article->getArticleProduct() || null === $article->getArticleProduct()->getProduct()){			
			return null;
		}	
	
		$images = $article
			->getArticleProduct()
			->getProduct()
			->getPrintSides()
			->map(function($printSide) use ($article){
				return $this->obtainPrintSideImage($article, $printSide);
			});		
		
		return $images;		
	}
	
	
	public function getPrintSidePreviewImage(ArticleInterface $article, string $printSideType)
	{
		if(null === $article->getArticleProduct()){
			return null;
		}
		
		$printSide = $article
			->getArticleProduct()
			->getProduct()
			->getPrintSides()
			->filter(function($value) use ($printSideType){
				return $value->getType()->getName() == $printSideType;
			})
			->first();	
			
		$image = $this->obtainPrintSideImage($article, $printSide);
		
		return $image;
	}
	
	private function obtainPrintSideImage(ArticleInterface $article, PrintSideInterface $printSide)
	{
		$printSideMatchedColor = $printSide
			->getSideProductColors()
			->filter(function($value) use ($article){
				if(null === $article->getArticleProduct()->getProductColors()) {
					return false;
				}
				
				return $value->getProductColors()->getColor() == $article->getArticleProduct()->getProductColors()->getColor();
			})
			->first();			
			
		return (false !== $printSideMatchedColor) ? $printSideMatchedColor->getImage() : null;
	}
	
	
}
