<?php

namespace Elcodi\Component\Media\Adapter\Combine\Interfaces;

use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

/**
 * Interface ResizerAdapterInterface.
 */
interface CombineAdapterInterface
{
    /**
     * Interface for image combine implementations.
     *
     * @param string $imageData Image Data
     * @param int    $height    Height value
     * @param int    $width     Width value
     * @param int    $type      Type
     *
     * @return string Resized image data
     */
    public function combine(
        $imageData,
        $text,
		$design
    );
}
