<?php

namespace Elcodi\Component\Media\Adapter\Combine;

use Symfony\Component\Process\ProcessBuilder;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignVariantInterface;

/**
 * Class DesignCombineAdapter.
 */
class DesignCombineAdapter
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
     * Array of DesignVariants 
     */
    private $designVariantsArray;
    
    /**
	 * @var string
	 * 
	 * Designs preview path 
	 */
	private $designsPreviewPath;
    
    private $resizeAdapter;
    
    /**
     * Constructor method.
     *
     * @param ProcessBuilder $processBuilder      Process builder
     * @param array          $designVariantsArray Array of DesignVariants 
     * @param string         $designsPreviewPath  Path of designs previews
     */
    public function __construct($processBuilder, $designVariantsArray, $designsPreviewPath, $resizeAdapter)
    {
        $this->processBuilder = $processBuilder;
        $this->designVariantsArray = $designVariantsArray;
        $this->designsPreviewPath = $designsPreviewPath;
        
        $this->resizeAdapter = $resizeAdapter;
    }       
    
    /**
     * Sets designs
     * 
     * @param array $designVariantsArray
     * @return $this
     */
    public function setDesigns()
    {
        foreach ($this->designVariantsArray as $designVariant) {
            if (null === $designVariant->getDesign()) {
                continue;
            }
            
            $this
                ->setDesignImage($designVariant)
                ->setPosition($designVariant)
                ->setCombineMode();
        }
        
        return $this->processBuilder;
    }
    
    /**
     * Sets design image
     * 
     * @param DesignVariantInterface $designVariant
     * @return $this
     */
    private function setDesignImage(DesignVariantInterface $designVariant)
    {
        $designFileName = $this->designsPreviewPath . '/' .
            $designVariant->getDesign()->getId() . '/0/0/'. 
            $designVariant->getDesign()->getPreviewFileName();
        
        $imageData = file_get_contents($designFileName);
        $tempFileName = tempnam(sys_get_temp_dir(), '_desine_resized'); 
       
        $resizedFileContent = $this
            ->resizeAdapter
            ->resize(
                $imageData, 
                $designVariant->getHeight(), 
                $designVariant->getWidth()
            );
        
        file_put_contents($tempFileName, $resizedFileContent);
        
        $this
            ->processBuilder
            ->add($tempFileName);            
        
        return $this;
    }
    
    /**
     * Sets design position
     * 
     * @param DesignVariantInterface $designVariant
     * @return $this
     */
    private function setPosition(DesignVariantInterface $designVariant)
    {
        $this
            ->processBuilder
            ->add('-geometry')
            ->add('+'.$designVariant->getPosX().'+'.$designVariant->getPosY());
        
        return $this;
    }
    
    /**
     * Sets combine mode
     * 
     * @return $this
     */
    private function setCombineMode()
    {
        $this
            ->processBuilder
            ->add('-composite');
        
        return $this;
    }
    
    
}
