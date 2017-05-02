<?php

namespace Elcodi\Component\Article\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Article\ElcodiArticleTypes;
use Elcodi\Component\Article\Entity\Article;
use Elcodi\Component\Article\Entity\ArticleProduct;
use Elcodi\Component\Article\Factory\ArticleProductFactory;
use Elcodi\Bundle\ProductBundle\Repository\ProductRepository;


/**
 * Factory for Article entities.
 */
class ArticleFactory extends AbstractFactory
{    
	/**
	 * @var $productRepository ProductRepository
	 * 
	 * Product Repository
	 */
	private $productRepository;
	
	/**
	 * @var $articleProductFactory ArticleProductFactory
	 * 
	 * Article Product Factory
	 */
	private $articleProductFactory;
	
	/**
	 * Construct 
	 * 
	 * @param ProductRepository $productRepository
	 * @param ArticleProductFactory $articleProductFactory
	 */
	public function __construct(ProductRepository $productRepository, AbstractFactory $articleProductFactory) 
	{
		$this->productRepository = $productRepository;
		$this->articleProductFactory = $articleProductFactory;
	}
	
    
    /**
     * Creates and returns a pristine Article instance.
     *
     * Prices are initialized to "zero amount" Money value objects,
     * using injected CurrencyWrapper default Currency
     *
     * @return Article New Article entity
     */
    public function create()
    {
        /**
         * @var Article $article
         */
        $classNamespace = $this->getEntityNamespace();
		
        $article = new $classNamespace();

        $article
            ->setType(ElcodiArticleTypes::TYPE_PRODUCT_PHYSICAL)
            ->setShowInHome(true)
            ->setAttributes(new ArrayCollection())
            ->setSectionCategories(new ArrayCollection())
            ->setEnabled(true)
			->setArticleProduct($this->getDefaultArticleProduct())
            ->setCreatedAt($this->now());

        return $article;
    }
	
	
	/**
	 * Get default product from existed products
	 * 
	 * @return ArticleProduct
	 */
	private function getDefaultArticleProduct()
	{
		$articleProduct = $this
			->articleProductFactory
			->create();
		
		$product = $this->productRepository->findOneBy([]);
		$productColors = $product
				->getColors()
				->first();		
		
		$articleProduct
            ->setProduct($product)
            ->setProductColors($productColors);
		
		return $articleProduct;
	}
}
