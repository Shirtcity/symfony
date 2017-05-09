<?php

namespace Elcodi\Component\Media\Adapter\Combine\Interfaces;

use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Interface ResizerAdapterInterface.
 */
interface CombineAdapterInterface
{
    /**
     * Interface for image combine implementations.
     *
     * @param ImageInterface $imageData Image
     * @param array          $texts		Texts
     * @param array          $designs	Designs
     *
     * @return string Combined image data
     */
    public function combine(
        $imageData,
        $texts,
		$designs
    );
}
