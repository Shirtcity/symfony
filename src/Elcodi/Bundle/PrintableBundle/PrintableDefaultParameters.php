<?php

namespace Elcodi\Bundle\PrintableBundle;

/**
 * Class ElcodiMediaImageResizeTypes.
 */
final class PrintableDefaultParameters
{
    /**
     * @var int
     * 
     * Minimal possible width of printable
     */
    const MIN_DESIGN_PRINTABLE_VARIANT_WIDTH = 50;
    
    /**
     * @var int 
     * 
     * Minimal possible height of printable
     */
    const MIN_DESIGN_PRINTABLE_VARIANT_HEIGHT = 50;
    
     /**
     * @var int
     * 
     * Maximal possible width of design
     */
    const MAX_DESIGN_WIDTH = 500;
    
    /**
     * @var int 
     * 
     * Maximal possible height of design
     */
    const MAX_DESIGN_HEIGHT = 500;
}
