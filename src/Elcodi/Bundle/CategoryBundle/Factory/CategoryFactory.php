<?php

namespace Elcodi\Bundle\CategoryBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Bundle\CategoryBundle\Entity\Category;

/**
 * Class CategoryFactory.
 */
class CategoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of Category.
     *
     * @return Category New Category entity
     */
    public function create()
    {
        /**
         * @var Category $category
         */
        $classNamespace = $this->getEntityNamespace();
        $category = new $classNamespace();
        $category
            ->setSubcategories(new ArrayCollection())
            ->setRoot(true)
            ->setPosition(0)
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $category;
    }
}
