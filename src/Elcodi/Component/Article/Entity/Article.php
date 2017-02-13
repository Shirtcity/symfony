<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Article\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Article\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;

/**
 * Class Article entity.
 */
class Article extends Purchasable implements ArticleInterface
{
    /**
     * @var int
     *
     * Article type
     */
    protected $type;

    /**
     * @var Collection
     *
     * Attributes associated with this article
     */
    protected $attributes;
	
	/**
     * @var ArticleProductInterface
	 * 
	 * Article products
     */
    protected $articleProduct;

	/**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
    /**
     * Set categories.
     *
     * @param Collection $categories Categories
     *
     * @return $this Self object
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Add category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function addCategory(CategoryInterface $category)
    {
        if (!$this
            ->categories
            ->contains($category)
        ) {
            $this
                ->categories
                ->add($category);
        }

        return $this;
    }

    /**
     * Remove category.
     *
     * @param CategoryInterface $category Category
     *
     * @return $this Self object
     */
    public function removeCategory(CategoryInterface $category)
    {
        $this
            ->categories
            ->removeElement($category);

        return $this;
    }

    /**
     * Set the principalCategory.
     *
     * @param CategoryInterface $principalCategory Principal category
     *
     * @return $this Self object
     */
    public function setPrincipalCategory(CategoryInterface $principalCategory = null)
    {
        $this->principalCategory = $principalCategory;

        return $this;
    }    

    /**
     * Sets Type.
     *
     * @param int $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Type.
     *
     * @return int Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Adds an attribute if not already in the collection.
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this Self object
     */
    public function addAttribute(AttributeInterface $attribute)
    {
        if (!$this
            ->attributes
            ->contains($attribute)) {
            $this
                ->attributes
                ->add($attribute);
        }

        return $this;
    }

    /**
     * Removes an attribute from the collection.
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return $this Self object
     */
    public function removeAttribute(AttributeInterface $attribute)
    {
        $this
            ->attributes
            ->removeElement($attribute);

        return $this;
    }

    /**
     * Returns article attributes.
     *
     * @return Collection Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets article attributes.
     *
     * @param Collection $attributes Attributes
     *
     * @return $this Self object
     */
    public function setAttributes(Collection $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }    

	/**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'article';
    }    

	/**
     * Set article product
     *
     * @param ArticleProductInterface $articleProduct
     *
     * @return Article
     */
    public function setArticleProduct(ArticleProductInterface $articleProduct)
    {
        $this->articleProduct = $articleProduct;

        return $this;
    }

    /**
     * Get article product
     *
     * @return ArticleProductInterface
     */
    public function getArticleProduct()
    {
        return $this->articleProduct;
    }   

    
}
