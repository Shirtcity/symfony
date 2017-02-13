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

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\ETaggableTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Media\Entity\Traits\ImagesContainerTrait;
use Elcodi\Component\Media\Entity\Traits\PrincipalImageTrait;
use Elcodi\Component\MetaData\Entity\Traits\MetaDataTrait;
use Elcodi\Component\Article\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\Entity\Traits\PurchasablePriceTrait;

/**
 * Class Purchasable.
 */
abstract class Purchasable implements PurchasableInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        ETaggableTrait,
        MetaDataTrait,
        ImagesContainerTrait,
        PrincipalImageTrait,
        EnabledTrait,
        PurchasablePriceTrait;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Article SKU
     */
    protected $sku;  

    /**
     * @var string
     *
     * Name
     */
    protected $name;
	

    /**
     * @var string
     *
     * Short description
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * Description
     */
    protected $description;

    /**
     * @var bool
     *
     * Article must show in home
     */
    protected $showInHome;

    /**
     * @var Collection
     *
     * Many-to-Many association between articles and categories.
     */
    protected $categories;

    /**
     * @var CategoryInterface
     *
     * Principal category
     */
    protected $principalCategory;

    /**
     * @var string
     *
     * Purchasable type
     */
    protected $purchasableType;

    /**
     * Get Slug.
     *
     * @return string Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets Slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get Sku.
     *
     * @return string Sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets Sku.
     *
     * @param string $sku Sku
     *
     * @return $this Self object
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }    

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get ShortDescription.
     *
     * @return string ShortDescription
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Sets ShortDescription.
     *
     * @param string $shortDescription ShortDescription
     *
     * @return $this Self object
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get Description.
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get ShowInHome.
     *
     * @return bool ShowInHome
     */
    public function getShowInHome()
    {
        return $this->showInHome;
    }

    /**
     * Sets ShowInHome.
     *
     * @param bool $showInHome ShowInHome
     *
     * @return $this Self object
     */
    public function setShowInHome($showInHome)
    {
        $this->showInHome = $showInHome;

        return $this;
    }

    /**
     * Get categories.
     *
     * @return Collection Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }    

    /**
     * Get the principalCategory.
     *
     * @return CategoryInterface Principal category
     */
    public function getPrincipalCategory()
    {
        return $this->principalCategory;
    }

    /**
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'purchasable';
}
}
