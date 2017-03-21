<?php

namespace Elcodi\Component\Article\Entity;

use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\Entity\ProductColor;

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
	private $productColor;
	
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
	public function getProductColor()
	{
		return $this->productColor;
	}
	
	/**
     * Adds product color
     *
     * @param ProductColor $productColor
     *
     * @return $this Self object;
     */
	public function setProductColor(ProductColor $productColor = null)
	{
		$this->productColor = $productColor;
		
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
