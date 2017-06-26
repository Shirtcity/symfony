<?php

namespace Elcodi\Component\Article\ImageResolver;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Media\Services\ImageResolver;
use Elcodi\Component\Media\Services\ImageManager;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\ImageResolver\Abstracts\AbstractImageResolverWithImageResolver;
use Elcodi\Component\Article\ImageResolver\Interfaces\ArticleImageResolverInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;
use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;
use Elcodi\Bundle\PrintableBundle\Entity\DesignVariant;

/**
 * Class ArticleImageResolver.
 */
class ArticleImageResolver extends AbstractImageResolverWithImageResolver implements ArticleImageResolverInterface
{
	/**
	 * @var ImageManager 
	 * 
	 * Image manager
	 */
	private $imageManager;
	
	/**
	 * Construct
	 * 
	 * @param ImageResolver $imageResolver
	 * @param ImageManager $imageManager
	 */
	public function __construct(ImageResolver $imageResolver, ImageManager $imageManager) 
	{
		$this->imageManager = $imageManager;
		
		parent::__construct($imageResolver);
	}
	
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
	 * Get article previews
	 * 
	 * @param ArticleInterface $article
	 * 
	 * @return ArrayCollection images
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
	
	/**
	 * Gets article preview image
	 * 
	 * @param ArticleInterface $article
	 * @param string $printSideType
	 * 
	 * @return ImageInterface image
	 */
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
	
	/**
	 * Obtains article product print side image 
	 * 
	 * @param ArticleInterface $article
	 * @param PrintSideInterface $printSide
	 * 
	 * @return ImageInterface image
	 */
	private function obtainPrintSideImage(ArticleInterface $article, PrintSideInterface $printSide)
	{
		$articleProductImage = $this->getArticleProductImage($article, $printSide);
		
        $texts = $designs = [];
        
		$article
			->getArticleProduct()
			->getArticleProductPrintSides()
			->filter(function($articleProductPrintSide) use ($printSide){
				return $articleProductPrintSide->getPrintSide()->getId() == $printSide->getId();
			})
            ->map( function($articleProductPrintSide) use (&$texts, &$designs) {
                $texts = $articleProductPrintSide
                    ->getTextPrintableVariants()
                    ->toArray();
            
                $designs = $articleProductPrintSide
                    ->getDesignPrintableVariants()
                    ->toArray();
            });
            
		$image = $this
			->imageManager
			->combine($articleProductImage, $texts, $designs);		
		
		return $image;
	}
    
    /**
     * Returns image of article product
     * 
     * @param ArticleInterface $article
     * @param PrintSideInterface $printSide
     * @return ImageInterface image
     */
    private function getArticleProductImage(ArticleInterface $article, PrintSideInterface $printSide)
    {
        if(null === $article->getArticleProduct()->getProductColors()) {
            return null;
        }
        
        $printSideMatchedColor = $printSide
			->getSideProductColors()
			->filter(function($sideProductColor) use ($article){
				return $sideProductColor->getProductColors()->getColor() == 
                       $article->getArticleProduct()->getProductColors()->getColor();
			})
			->first();
        
		if (empty($printSideMatchedColor)) {			
			return null;
		}
        
        return $printSideMatchedColor->getImage();
    }
    
	
	
}
