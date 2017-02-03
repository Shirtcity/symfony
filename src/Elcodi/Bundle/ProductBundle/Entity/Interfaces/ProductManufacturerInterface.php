<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImagesContainerWithPrincipalImageInterface;
use Elcodi\Component\MetaData\Entity\Interfaces\MetaDataInterface;

/**
 * Interface ProductManufacturerInterface.
 */
interface ProductManufacturerInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface,
    MetaDataInterface,
    ImagesContainerWithPrincipalImageInterface
{
    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Set description.
     *
     * @param string $description Description
     *
     * @return $this Self object
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * Set slug.
     *
     * @param string $slug Slug
     *
     * @return $this Self object
     */
    public function setSlug($slug);

    /**
     * Get slug.
     *
     * @return string Slug
     */
    public function getSlug();
}
