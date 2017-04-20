<?php

namespace Elcodi\Component\Article\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Factory\Traits\EntityNamespaceTrait;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Bundle\ProductBundle\Entity\PrintSide;
use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;

/**
 * Class ArticleProduct entity.
 */
class ArticleProductPrintSide implements ArticleProductPrintSideInterface
{	
	use EntityNamespaceTrait;
    /**
     * @var integer
     */
    private $id;

	/**
	 * @var PrintSide
	 */
	private $printSide;
	
	/**
	 * @var PrintableVariant 
	 */
	private $printableVariants;
	
	 /**
     * @var ArticleProductInterface
     *
     * ArticleProduct
     */
    private $articleProduct;
	
	/**
     * Returns article product print side
     *
     * @return PrintSide;
     */
	public function getPrintSide()
	{
		return $this->printSide;
	}
	
	/**
     * Sets article product print side
     *
     * @param PrintSide $printSide
     *
     * @return $this Self object;
     */
	public function setPrintSide(PrintSide $printSide = null)
	{
		$this->printSide = $printSide;
		
		return $this;
	}
	
	/**
     * Returns article print side printable variants
     *
     * @return Collection;
     */
	public function getPrintableVariants()
	{
		return $this->printableVariants;
	}
	
	/**
     * Sets article print side printable variants
     *
     * @param Collection $printableVariants
     *
     * @return $this Self object;
     */
	public function setPrintableVariants(Collection $printableVariants = null)
	{
		$this->printableVariants = $printableVariants;
		
		return $this;
	}
	
	/**
     * Adds article print side printable variant to PrintableVariants
	 * 
	 * @param PrintableVariant $printableVariant
     *
     * @return $this Self object;
     */
	public function addPrintableVariant(PrintableVariant $printableVariant)
	{
		$this->printableVariants->add($printableVariant);
		
		return $this;
	}
	
	/**
     * Removes article print side printable variant from PrintableVariants
     *
     * @param PrintableVariant $printableVariant
     *
     * @return $this Self object;
     */
	public function removePrintableVariant(PrintableVariant $printableVariant)
	{
		$this->printableVariants->remove($printableVariant);
		
		return $this;
	}
	
	/**
     * Get Article Product
     *
     * @return ArticleProductInterface
     */
    public function getArticleProduct()
	{
		return $this->articleProduct;
	}
	
	/**
     * Set Article Product
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     *
     * @return $this Self object
     */
    public function setArticleProduct(ArticleProductInterface $articleProduct = null)
	{
		$this->articleProduct = $articleProduct;
		
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
