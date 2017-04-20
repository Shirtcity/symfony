<?php

namespace Elcodi\Component\Article\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Article\Entity\ArticleProductPrintSide;

/**
 * Factory for ArticleProduct entities.
 */
class ArticleProductFactory extends AbstractFactory
{
	/**
     * Creates and returns a pristine ArticleProduct instance.
     *
     * @return ArticleProduct New ArticleProduct entity
     */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
	
        $articleProduct = new $classNamespace();
				
        $articleProduct
            ->setProduct()
            ->setProductColors()
			->setArticleProductPrintSides(new ArrayCollection());
		
        return $articleProduct;
    }
}
