<?php
namespace Elcodi\Component\Article\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Bundle\ProductBundle\Entity\PrintSide;
use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;

interface ArticleProductPrintSideInterface
{
	/**
     * Returns article product print side
     *
     * @return PrintSide;
     */
	public function getPrintSide();
	
	/**
     * Sets article product print side
     *
     * @param PrintSide $printSide
     *
     * @return $this Self object;
     */
	public function setPrintSide(PrintSide $printSide);
	
	/**
     * Returns article print side printable variants
     *
     * @return Collection;
     */
	public function getPrintableVariants();
	
	/**
     * Sets article print side printable variants
     *
     * @param Collection $printableVariants
     *
     * @return $this Self object;
     */
	public function setPrintableVariants(Collection $printableVariants);
	
	/**
     * Returns article print side printable variant
	 * 
	 * @param PrintableVariant $printableVariant
     *
     * @return $this Self object;
     */
	public function addPrintableVariant(PrintableVariant $printableVariant);
	
	/**
     * Sets article print side printable variant
     *
     * @param PrintableVariant $printableVariant
     *
     * @return $this Self object;
     */
	public function removePrintableVariant(PrintableVariant $printableVariant);
	
	/**
     * Set Article Product
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     *
     * @return $this Self object
     */
    public function setArticleProduct(ArticleProductInterface $articleProduct);

    /**
     * Get Article Product
     *
     * @return ArticleProductInterface
     */
    public function getArticleProduct();
	
}

