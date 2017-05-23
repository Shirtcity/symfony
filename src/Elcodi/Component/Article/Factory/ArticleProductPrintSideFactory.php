<?php

namespace Elcodi\Component\Article\Factory;

use \Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Factory for ArticleProduct entities.
 */
class ArticleProductPrintSideFactory extends AbstractFactory
{	
	/**
     * Creates and returns a pristine ArticleProductPrintSide instance.
     *
     * @return ArticleProductPrintSide New ArticleProductPrintSide entity
     */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
	
        $articleProductPrintSide = new $classNamespace();       

        $articleProductPrintSide
            ->setPrintSide()
            ->setPrintableVariants(new ArrayCollection())
            ->enable();

        return $articleProductPrintSide;
    }	
}
