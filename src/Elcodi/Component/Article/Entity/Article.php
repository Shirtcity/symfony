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
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Component\Article\PriceResolver\ArticlePriceResolver;

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
     * @var Collection
     *
     * Many-to-Many association between articles and section categories.
     */
    protected $sectionCategories;
	
	/**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
    /**
     * Set section categories.
     *
     * @param Collection $sectionCategories SectionCategories
     *
     * @return $this Self object
     */
    public function setSectionCategories(Collection $sectionCategories)
    {
        $this->sectionCategories = $sectionCategories;

        return $this;
    }

    /**
     * Add section category.
     *
     * @param CategoryInterface $sectionCategory SectionCategory
     *
     * @return $this Self object
     */
    public function addSectionCategory(CategoryInterface $sectionCategory)
    {
        if (!$this
            ->sectionCategories
            ->contains($sectionCategory)
        ) {
            $this
                ->sectionCategories
                ->add($sectionCategory);
        }

        return $this;
    }
	
	/**
     * Get section categories.
     *
     * @return Collection SectionCategories
     */
    public function getSectionCategories()
	{
		return $this->sectionCategories;
	}

    /**
     * Remove section category.
     *
     * @param CategoryInterface $sectionCategory SectionCategory
     *
     * @return $this Self object
     */
    public function removeSectionCategory(CategoryInterface $sectionCategory)
    {
        $this
            ->sectionCategories
            ->removeElement($sectionCategory);

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
