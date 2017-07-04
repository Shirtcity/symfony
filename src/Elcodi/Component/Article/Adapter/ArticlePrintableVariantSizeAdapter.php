<?php

namespace Elcodi\Component\Article\Adapter;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Bundle\PrintableBundle\PrintableDefaultParameters;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;


/**
 * Class ArticlePrintableVariantSizeAdapter
 */
class ArticlePrintableVariantSizeAdapter
{    
    /**
     * Default width of printable image
     * 
     * @var integer 
     */
    private $defaultImageWidth = PrintableDefaultParameters::MAX_DESIGN_WIDTH;
    
    /**
     * Default height of printable image
     * 
     * @var integer 
     */
    private $defaultImageHeight = PrintableDefaultParameters::MAX_DESIGN_HEIGHT;
    
    /**
     * Printable variant
     * 
     * @var PrintableVariantInterface 
     */
    private $printableVariant;
    
    /**
     * Print side area
     * 
     * @var PrintSideAreaInterface 
     */
    private $printSideArea;
    
    /**
     * Set printable variant
     * 
     * @param PrintableVariantInterface $printableVariant
     * 
     * @return $this
     */
    public function setPrintableVariant(PrintableVariantInterface $printableVariant)
    {
        $this->printableVariant = $printableVariant;
        
        return $this;
    }
    
    /**
     * Set print side area
     * 
     * @param PrintSideAreaInterface $printSideArea
     * 
     * @return $this
     */
    public function setPrintSideArea(PrintSideAreaInterface $printSideArea)
    {
        $this->printSideArea = $printSideArea;
        
        return $this;
    }
    
    /**
     * Adapt printable size
     * 
     * @return boolean
     */
    public function adaptPrintableSize() 
    {  
        $printableResized = false;
        
        if ($this->isPrintableVariantResizable()) {            
            $this
                ->adaptWidth()
                ->adaptHeight();
            
            $printableResized = true;
        }
        
        return $printableResized;
    }
    
    /**
     * Scale printable height in proportion to a width
     * 
     * @return $this
     */
    public function scalePrintableHeight()
    {
        $varianWidth = $this
            ->printableVariant
            ->getWidth();
          
        $percentWidth = ceil($varianWidth * 100 / $this->defaultImageWidth);
        $variantHeight = ceil($percentWidth * $this->defaultImageHeight / 100);
       
        $this
            ->printableVariant
            ->setHeight($variantHeight);
        
        return $this;
    }
    
    /**
     * Scale printable width in proportion to a height
     * 
     * @return $this
     */
    public function scalePrintableWidth()
    {
        $varianHeight = $this
            ->printableVariant
            ->getHeight();

        $percentHeight = ceil($varianHeight * 100 / $this->defaultImageHeight);
        $variantWidth = ceil($percentHeight * $this->defaultImageWidth / 100);   
       
        $this
            ->printableVariant
            ->setWidth($variantWidth);
        
        return $this;
    }    
    
    /**
     * Check if printable variant could be made smaller   
     * 
     * Takes the current printable XY position and cuts the image by print side right and bottom borders -  
     * if after that its height and width is bigger than MIN_DESIGN_PRINTABLE_VARIANT_HEIGHT 
     * and MIN_DESIGN_PRINTABLE_VARIANT_WIDTH - printable is resizable
     * 
     * @return boolean
     */
    private function isPrintableVariantResizable() 
    {
        $printSideAreaPositionXMax = $this->printSideArea->getPosX() + $this->printSideArea->getWidth();
        $printSideAreaPositionYMax = $this->printSideArea->getPosY() + $this->printSideArea->getHeight();
              
        $printableWidthAfterAdapting = $printSideAreaPositionXMax - $this->printableVariant->getPosX();
        $printableHeightAfterAdapting = $printSideAreaPositionYMax - $this->printableVariant->getPosY();
    
        return ($printableWidthAfterAdapting > PrintableDefaultParameters::MIN_DESIGN_PRINTABLE_VARIANT_WIDTH) 
               && ($printableHeightAfterAdapting > PrintableDefaultParameters::MIN_DESIGN_PRINTABLE_VARIANT_HEIGHT);
    }
    
    /**
     * Adapt printable width for a given print side area
     * 
     * @return $this
     */
    private function adaptWidth()
    {         
        $printSideRightBorder = $this->printSideArea->getPosX() + $this->printSideArea->getWidth();

        $printableVariantAdaptedWidth = $printSideRightBorder - $this->printableVariant->getPosX(); 
        
        $this
            ->printableVariant
            ->setWidth($printableVariantAdaptedWidth);

        return $this;
    }
    
    /**
     * Adapt printable height for a given print side area
     * 
     * @return $this
     */
    private function adaptHeight() 
    {                      
        $printSideBottomBorder = $this->printSideArea->getPosY() + $this->printSideArea->getHeight();

        $this->scalePrintableHeight(); 

        $printableVariantAdaptedHeight = $printSideBottomBorder - $this->printableVariant->getPosY();

        if ($this->printableVariant->getHeight() > $printableVariantAdaptedHeight) {                
            $this
                ->printableVariant
                ->setHeight($printableVariantAdaptedHeight);
            
            $this->scalePrintableWidth();
        }
        
        return $this;
    }
}

