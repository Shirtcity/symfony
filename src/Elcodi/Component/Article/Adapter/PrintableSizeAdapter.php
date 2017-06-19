<?php

namespace Elcodi\Component\Article\Adapter;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Bundle\PrintableBundle\PrintableDefaultParameters;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;


/**
 * Class PrintablePositionAdapter
 */
class PrintableSizeAdapter
{    
    /**
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param PrintSideAreaInterface $printSideArea
     */
    public function adaptPrintableSize(
        PrintableVariantInterface $printableVariant, 
        PrintSideAreaInterface $printSideArea
    ) {  
        $printableResized = false;
        
        if ($this->isResizable($printableVariant, $printSideArea)) {
            $printSideRightBorder = $printSideArea->getPosX() + $printSideArea->getWidth();
            //$printSideBottomBorder = $printSideArea->getPosY() + $printSideArea->getHeight();
                    
            $printableVariantAdaptedWidth = $printSideRightBorder - $printableVariant->getPosX();            
            //$printableVariantAdaptedHeight = $printSideBottomBorder - $printableVariant->getPosY();
            
            $this->adaptPrintableHeightInProportionToSize();
            
            $printableVariant->setWidth($printableVariantAdaptedWidth);
            //$printableVariant->setHeight($printableVariantAdaptedHeight);
            
            
            $printableResized = true;
        }
        
        return $printableResized;
    }
    
    /**
     * Check if printable variant could be made smaller   
     * 
     * Takes the current printable XY position and cuts the image by print side right and bottom borders -  
     * if after that its height and width is bigger than MIN_DESIGN_PRINTABLE_VARIANT_HEIGHT 
     * and MIN_DESIGN_PRINTABLE_VARIANT_WIDTH - printable is resizable
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param PrintSideAreaInterface $printSideArea
     * 
     * @return boolean
     */
    private function isResizable(
        PrintableVariantInterface $printableVariant, 
        PrintSideAreaInterface    $printSideArea
    ) {
        $printSideAreaPositionXMax = $printSideArea->getPosX() + $printSideArea->getWidth();
        $printSideAreaPositionYMax = $printSideArea->getPosY() + $printSideArea->getHeight();
              
        $printableWidthAfterAdapting = $printSideAreaPositionXMax - $printableVariant->getPosX();
        $printableHeightAfterAdapting = $printSideAreaPositionYMax - $printableVariant->getPosY();
    
        return ($printableWidthAfterAdapting > PrintableDefaultParameters::MIN_DESIGN_PRINTABLE_VARIANT_WIDTH) 
               && ($printableHeightAfterAdapting > PrintableDefaultParameters::MIN_DESIGN_PRINTABLE_VARIANT_HEIGHT);
    }
}

