<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Interfaces;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Photo;

interface PhotoVariantInterface extends PrintableVariantInterface
{
    /**
     * Set photo
     *
     * @param Photo $photo
     *
     * @return PhotoVariant
     */
    public function setPhoto(Photo $photo);

    /**
     * Get photo
     *
     * @return Photo
     */
    public function getPhoto();
}