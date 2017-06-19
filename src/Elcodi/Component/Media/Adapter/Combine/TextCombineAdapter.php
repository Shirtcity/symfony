<?php

namespace Elcodi\Component\Media\Adapter\Combine;

use Symfony\Component\Process\ProcessBuilder;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextVariantInterface;

/**
 * Class TextCombineAdapter.
 */
class TextCombineAdapter 
{  
    /**
     * @var ProcessBuilder
     * 
     * Process builder
     */
    private $processBuilder;
    
    /**
     * @var array
     * 
     * Array of TextVariants 
     */
    private $textVariantsArray;
    
    /**
     * Constructor method.
     *
     * @param ProcessBuilder $processBuilder    Process builder
     * @param array          $textVariantsArray Array of TextVariants 
     */
    public function __construct($processBuilder, $textVariantsArray)
    {
        $this->processBuilder = $processBuilder;
        $this->textVariantsArray = $textVariantsArray;
    }    
    
    /**
     * Sets texts
     * 
     * @param Array $textVariantsArray
     * @return $this
     */
    public function setTexts()
    {        
        foreach ($this->textVariantsArray as $textVariant) { 
            
            if ( null === $textVariant->getText()) {
                continue;
            }
            
            $this
                ->setTextFoilColor($textVariant)
                ->setFontSize()
                ->setFont($textVariant)
                ->setTextPosition($textVariant)                
                ->setTextContent($textVariant);
        }
        
        return $this->processBuilder;
    }
    
    /**
     * Sets text foil color 
     * 
     * @param TextVariantInterface $textVariant
     * @return $this
     */
    private function setTextFoilColor(TextVariantInterface $textVariant)
    {
        $foilColorHexCode = $textVariant
            ->getText()
            ->getFoilColor()
            ->getCode();        
      
        $this->processBuilder
            ->add('-fill')
            ->add($foilColorHexCode);
        
        return $this;
    }
    
    /**
     * Sets font
     * 
     * @param TextVariantInterface $textVariant
     * @return $this
     */
    private function setFont(TextVariantInterface $textVariant)
    {
        $fontName = $textVariant
            ->getText()
            ->getFont()
            ->getName();
        
        $this->processBuilder
            ->add('-font')
            ->add($fontName);
        
        return $this;
    }
    
    /**
     * Sets text position
     * 
     * @param TextVariantInterface $textVariant
     * @return $this
     */
    private function setTextPosition(TextVariantInterface $textVariant)
    {
        $positionX = $textVariant->getPosX();
        $positionY = $textVariant->getPosY();
        
        $this->processBuilder
            ->add('-gravity')
            ->add('NorthWest')
            ->add('-annotate')
            ->add("+$positionX+$positionY");
        
        return $this;
    }
    
    /**
     * Sets font size
     * 
     * @return $this
     */
    private function setFontSize()
    {
        $this->processBuilder
            ->add('-weight')
            ->add(14);

        $this->processBuilder
            ->add('-pointsize')
            ->add(25);
        
        return $this;
    }
    
    /**
     * Sets text content
     * 
     * @param TextVariantInterface $textVariant
     * @return $this
     */
    private function setTextContent(TextVariantInterface $textVariant)
    {
        $textContnet = $textVariant
            ->getText()
            ->getContent();            
        
        $this
            ->processBuilder
            ->add($textContnet);
        
        return $this;
    }  
    
}
