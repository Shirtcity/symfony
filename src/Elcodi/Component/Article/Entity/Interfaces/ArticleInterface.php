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

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;

/**
 * Interface ArticleInterface.
 */
interface ArticleInterface extends PurchasableInterface, CategorizableInterface
{
    /**
     * Set article manufacturer.
     *
     * @param ManufacturerInterface $manufacturer Manufacturer
     *
     * @return $this Self object
     */
    public function setManufacturer(ManufacturerInterface $manufacturer = null);

    /**
     * Returns article principal variant.
     *
     * @return VariantInterface
     */
    public function getPrincipalVariant();

    /**
     * Sets article principal variant.
     *
     * @param VariantInterface $principalVariant
     *
     * @return $this Self object
     */
    public function setPrincipalVariant(VariantInterface $principalVariant);

    /**
     * Adds an attribute if not already in the collection.
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this Self object;
     */
    public function addAttribute(AttributeInterface $attribute);

    /**
     * Removes an attribute from the collection.
     *
     * @param AttributeInterface $attribute Attribute to be removed
     *
     * @return $this Self object
     */
    public function removeAttribute(AttributeInterface $attribute);

    /**
     * Returns article attributes.
     *
     * @return Collection Attributes
     */
    public function getAttributes();

    /**
     * Sets article attributes.
     *
     * @param Collection $attributes Attributes
     *
     * @return $this Self object
     */
    public function setAttributes(Collection $attributes);

    /**
     * Gets article variants.
     *
     * @return Collection Variants
     */
    public function getVariants();

    /**
     * Adds a Variant for this Article.
     *
     * @param VariantInterface $variant Variant
     *
     * @return $this Self object
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Sets article variants.
     *
     * @param Collection $variants Variants
     *
     * @return $this Self object
     */
    public function setVariants(Collection $variants);

    /**
     * Tells if this article has variants.
     *
     * @return bool Article has variants
     */
    public function hasVariants();

    /**
     * Sets Type.
     *
     * @param int $type Type
     *
     * @return $this Self object
     */
    public function setType($type);

    /**
     * Get Type.
     *
     * @return int Type
     */
    public function getType();
}
