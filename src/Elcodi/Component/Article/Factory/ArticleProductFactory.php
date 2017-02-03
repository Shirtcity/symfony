<?php

namespace Elcodi\Component\Article\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

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
            ->setProductColor();

        return $articleProduct;
    }
}
