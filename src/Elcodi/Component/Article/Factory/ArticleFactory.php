<?php

namespace Elcodi\Component\Article\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Article\ElcodiArticleTypes;
use Elcodi\Component\Article\Entity\Article;
use Elcodi\Component\Article\Entity\ArticleProduct;


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
	 * Construct 
	 * 
	 * @param EntityRepository $productRepository
	 */
	public function __construct(EntityRepository $productRepository) {
		$this->productRepository = $productRepository;
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
		$articleProduct = new ArticleProduct();
		
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
