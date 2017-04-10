<?php

namespace Elcodi\Bundle\ProductBundle\Entity\Interfaces;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

use Elcodi\Bundle\ProductBundle\Entity\Interfaces\ProductColorsInterface;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideInterface;

/**
 * Interface PrintSideProductColorsInterface.
 */
interface PrintSideProductColorsInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set productColors
     *
     * @param ProductColorsInterface $productColors
     *
     * @return PrintSideProductColors
     */
    public function setProductColors(ProductColorsInterface $productColors = null);

    /**
     * Get productColors
     *
     * @return ProductColorsInterface
     */
    public function getProductColors();

    /**
     * Get Image.
     *
     * @return ImageInterface Image
     */
    public function getImage();

    /**
     * Sets Image.
     *
     * @param ImageInterface $image Image
     *
     * @return $this Self object
     */
    public function setImage(ImageInterface $image = null);

    /**
     * Set side
     *
     * @param PrintSideInterface $side
     *
     * @return PrintSideProductColors
     */
    public function setSide(PrintSideInterface $side);

    /**
     * Get side
     *
     * @return PrintSideInterface
     */
    public function getSide();
}
