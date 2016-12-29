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

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Article\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\ManufacturerInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\VariantInterface;

/**
 * Class Variant.
 *
 * A Article variant is a specific combination of finite options
 * for a given Article. The multiplicity of attribute/options define
 * a "tuple" of a article and its related options such that a specific
 * combination is univocally determined.
 *
 * A Variant will normally have a different SKU than its parent article,
 * so it can have independent stock and pricing informations.
 */
class Variant extends Purchasable implements VariantInterface
{
    /**
     * @var ArticleInterface
     *
     * Parent article
     */
    protected $article;

    /**
     * @var Collection
     *
     * Collection of possible options for this article
     */
    protected $options;

    /**
     * Gets parent article.
     *
     * @return ArticleInterface
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Sets parent article.
     *
     * @param ArticleInterface $article
     *
     * @return $this Self object
     */
    public function setArticle(ArticleInterface $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Gets this variant option values.
     *
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets this variant option values.
     *
     * @param Collection $options
     *
     * @return $this Self object
     */
    public function setOptions(Collection $options)
    {
        /**
         * We want to be able to assign an empty
         * ArrayCollection to variant options.
         *
         * When the collection is not empty, each
         * option in the collection will be added
         * separately since it needs to update the
         * parent article attribute list
         */
        if ($options->isEmpty()) {
            $this->options = $options;
        } else {
            $this->options->clear();
        }

        /**
         * @var ValueInterface $option
         */
        foreach ($options as $option) {

            /**
             * We need to update the parent article attribute collection.
             */
            $this->addOption($option);
        }

        return $this;
    }

    /**
     * Adds an option to this variant.
     *
     * Passed option Attribute is also added to the attribute collection
     * of the parent Article.
     *
     * If Variant::article is not set or does not implement ArticleInterface
     * a LogicException is thrown: presence of the parent article is mandatory
     * since adding an Option to a Variant also updates the Parent article
     * Attribute collection. This way Variant::options and Article::attributes
     * are synchronized
     *
     * @param ValueInterface $option
     *
     * @throws \LogicException
     *
     * @return $this Self object
     */
    public function addOption(ValueInterface $option)
    {
        if (!$this->article instanceof ArticleInterface) {
            throw new \LogicException('Cannot add options to a Variant before setting a parent Article');
        }

        $this
            ->options
            ->add($option);

        $this
            ->article
            ->addAttribute(
                $option->getAttribute()
            );

        return $this;
    }

    /**
     * Removes an option from this variant.
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function removeOption(ValueInterface $option)
    {
        $this
            ->options
            ->removeElement($option);

        return $this;
    }

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this
            ->getArticle()
            ->getCategories();
    }

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this
            ->getArticle()
            ->getPrincipalCategory();
    }

    /**
     * Article manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer()
    {
        return $this
            ->getArticle()
            ->getManufacturer();
    }

    /**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'article_variant';
    }
}
