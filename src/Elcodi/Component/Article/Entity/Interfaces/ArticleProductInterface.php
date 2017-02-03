<?php
namespace Elcodi\Component\Article\Entity\Interfaces;

use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\Entity\ProductColor;

interface ArticleProductInterface
{
	/**
     * Returns product of an article
     *
     * @return Product;
     */
	public function getProduct();
	
	/**
     * Adds a product to an article
     *
     * @param Product $product
     *
     * @return $this Self object;
     */
	public function setProduct(Product $product);
	
	/**
     * Returns product color
     *
     * @return ProductColor;
     */
	public function getProductColor();
	
	/**
     * Adds product color
     *
     * @param ProductColor $productColor
     *
     * @return $this Self object;
     */
	public function setProductColor(ProductColor $productColor);
	
	/*
	public function getPrintArea();	
	public function setPrintArea($printArea);
	 */
}

