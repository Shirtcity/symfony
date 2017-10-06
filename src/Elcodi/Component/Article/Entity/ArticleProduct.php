<?php

namespace Elcodi\Component\Article\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use \Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
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
	 * @var ProductColors 
	 */
	private $productColors;	
	
	/**
     * @var Collection
     *
     * Lines
     */
    protected $articleProductPrintSides;
	
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
     * Gets article product print sides.
     *
     * @return Collection ArticleProductPrintSide collection
     */
    public function getArticleProductPrintSides()
	{
		return $this->articleProductPrintSides;
	}
	
	/**
     * Sets article product print sides
     *
     * @param Collection $articleProductPrintSides Article Product Print Sides
     *
     * @return $this Self object
     */
    public function setArticleProductPrintSides(Collection $articleProductPrintSides)
	{
		$this->articleProductPrintSides = $articleProductPrintSides;
		
		return $this;
	}
	
	/**
	 * Add new article product print side to the collection
	 * 
	 * @param ArticleProductPrintSideInterface $articleProductPrintSide
	 */
	public function addArticleProductPrintSide(ArticleProductPrintSideInterface $articleProductPrintSide)
	{
		$this->articleProductPrintSides->add($articleProductPrintSide);
	}
	
	/**
	 * Removes an article product print side from the collection
	 * 
	 * @param ArticleProductPrintSideInterface $articleProductPrintSide
	 */
	public function removeArticleProductPrintSide(ArticleProductPrintSideInterface $articleProductPrintSide)
	{
		$this->articleProductPrintSides->removeElement($articleProductPrintSide);
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
