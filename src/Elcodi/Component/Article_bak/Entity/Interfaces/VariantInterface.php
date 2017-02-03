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

namespace Elcodi\Component\Article\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;

/**
 * Interface VariantInterface.
 *
 * A Article variant is a specific combination of finite options
 * for a given Article.
 */
interface VariantInterface extends PurchasableInterface
{
    /**
     * Gets parent article.
     *
     * @return ArticleInterface Article
     */
    public function getArticle();

    /**
     * Sets parent article.
     *
     * @param ArticleInterface $article
     *
     * @return $this Self object
     */
    public function setArticle(ArticleInterface $article);

    /**
     * Gets this variant option values.
     *
     * @return Collection Variant options
     */
    public function getOptions();

    /**
     * Sets this variant option values.
     *
     * @param Collection $options
     *
     * @return $this Self object
     */
    public function setOptions(Collection $options);

    /**
     * Adds an option to this variant.
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function addOption(ValueInterface $option);

    /**
     * Removes an option from this variant.
     *
     * @param ValueInterface $option
     *
     * @return $this Self object
     */
    public function removeOption(ValueInterface $option);

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories();

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory();

    /**
     * Article manufacturer.
     *
     * @return ManufacturerInterface Manufacturer
     */
    public function getManufacturer();
}
