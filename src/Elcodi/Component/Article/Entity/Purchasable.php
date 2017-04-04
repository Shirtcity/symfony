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
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Bundle\PriceBundle\Entity\Traits\PriceTrait;

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
        PriceTrait;

    /**
     * @var string
     *
     * Slug
     */
    protected $slug;

    /**
     * @var string
     *
     * Name
     */
    protected $name;	    

    /**
     * @var bool
     *
     * Article must show in home
     */
    protected $showInHome;        

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
     * Get purchasable type.
     *
     * @return string Purchasable type
     */
    public function getPurchasableType()
    {
        return 'purchasable';
}
}
