<?php

namespace Elcodi\Component\Article\Tests\UnitTest\PriceResolver;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Bundle\PriceBundle\Entity\Price;
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Article\PriceResolver\ArticlePriceResolver;

/**
 * Class ArticlePriceResolverTest
 */
class ArticlePriceResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test for Article twig extension
     */
    public function testArticlePrice()
    {
        $article = $this->getMockBuilder('Elcodi\Component\Article\Entity\Article')
			->disableOriginalConstructor(true)
			->getMock();
		
		$product = $this->getMockBuilder('Elcodi\Bundle\ProductBundle\Entity\Product')
			->disableOriginalConstructor(true)
			->getMock();
				
		$articleProduct = $this->getMockBuilder('Elcodi\Component\Article\Entity\ArticleProduct')
			->disableOriginalConstructor(true)
			->getMock();
				
        $currency = new Currency();
        $currency->setIso('USD');        
		
		$money = Money::create(
            20000,
            $currency
        );
		
        $price = new Price();
		$price->setPrice($money);
		$price->setPriceCurrency($currency);

		$product->setPrices(new ArrayCollection([$money]));
		$articleProduct->setProduct($product);
		$article->setArticleProduct($articleProduct);
		
		$article
			->method('getArticleProduct')
			->will($this->returnValue($articleProduct));
		
		$articleProduct
			->method('getProduct')
			->will($this->returnValue($product));
		
		$product
			->method('getPrices')
			->will($this->returnValue(new ArrayCollection([$money])));
		
        $articlePriceResolver = new ArticlePriceResolver();

        $this->assertEquals(
            $money,
            $articlePriceResolver->getPrice(
                $article,
				$currency
            )
        );
    }
}
