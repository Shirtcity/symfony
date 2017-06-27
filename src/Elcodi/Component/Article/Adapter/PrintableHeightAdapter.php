<?php

namespace Elcodi\Component\Article\Adapter;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;

/**
 * Class PrintablePositionAdapter
 */
class PrintableHeightAdapter
{    
    /**
     * 
     * @param PrintableVariantInterface $printableVariant
     */
    public function adaptPrintableHeight(
        PrintableVariantInterface $printableVariant
    ) {  
        $heightProportionedByWidth = $this
            ->calculateHeightInProportionToWidth($printableVariant);
        
        $printableVariant
            ->setHeight($heightProportionedByWidth);          
    }
    
    /**
     * Calculate height of a printable in proportion to a width
     *  
     * @param PrintableVariantInterface $printableVariant
     * 
     * @return int $heightProportionedByWidth
     */
    private function calculateHeightInProportionToWidth(PrintableVariantInterface $printableVariant)
    {
        /* @TODO: variant->getDesign()->getImageWidth();
         * varianWidth = $printableVariant->getWidth();
         * imageWidth = variant->getDesign()->getImageWidth();
         * imageHeight = variant->getDesign()->getImageHeight();
         * 
         * percentWidth = varianWidth * 100 / imageWidth;
         * variantHeight = percentWidth * imageHeight / 100;
         * 
         * return variantHeight;
        */
        
        return $printableVariant->getWidth();
    }
}

