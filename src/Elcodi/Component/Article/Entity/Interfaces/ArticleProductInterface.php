<?php
namespace Elcodi\Component\Article\Entity\Interfaces;

use Elcodi\Bundle\ProductBundle\Entity\Product;
use Elcodi\Bundle\ProductBundle\Entity\ProductColors;

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
     * Returns product colors
     *
     * @return ProductColors;
     */
	public function getProductColors();
	
	/**
     * Adds product color
     *
     * @param ProductColors $productColors
     *
     * @return $this Self object;
     */
	public function setProductColors(ProductColors $productColors);
	
	/*
	public function getPrintArea();	
	public function setPrintArea($printArea);
	 */
}

