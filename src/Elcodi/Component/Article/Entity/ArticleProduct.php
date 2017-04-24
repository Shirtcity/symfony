<?php

namespace Elcodi\Component\Article\Entity;

use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\Entity\ProductColors;

/**
 * Class ArticleProduct entity.
 */
class ArticleProduct implements ArticleProductInterface
{	
	use EntityNamespaceTrait;
    /**
     * @var integer
     */
    private $id;

	/**
	 * @var Product
	 */
	private $product;
	
	/**
	 * @var ProductColor 
	 */
	private $productColors;
	
	/**
     * Returns product of an article
     *
     * @return Product;
     */
	public function getProduct()
	{
		return $this->product;
	}
	
	/**
     * Adds a product to an article
     *
     * @param Product $product
     *
     * @return $this Self object;
     */
	public function setProduct(Product $product = null)
	{
		$this->product = $product;
		
		return $this;
	}
	
	/**
     * Returns product color
     *
     * @return ProductColor;
     */
	public function getProductColors()
	{
		return $this->productColors;
	}
	
	/**
     * Adds product color
     *
     * @param ProductColors $productColors
     *
     * @return $this Self object;
     */
	public function setProductColors(ProductColors $productColors = null)
	{
		$this->productColors = $productColors;
		
		return $this;
	}
	

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
	
	/**
     * To string method.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
