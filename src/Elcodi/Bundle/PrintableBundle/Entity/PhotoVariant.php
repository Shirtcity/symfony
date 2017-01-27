<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PhotoVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Photo;

/**
 * PhotoVariant
 */
class PhotoVariant extends PrintableVariant implements PhotoVariantInterface
{

    /**
     * @var Photo
     */
    private $photo;


    /**
     * Set photo
     *
     * @param Photo $photo
     *
     * @return PhotoVariant
     */
    public function setPhoto(Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
