<?php

namespace Elcodi\Component\Media\Adapter\Combine;

use Symfony\Component\Process\ProcessBuilder;

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
    
    /**
     * Constructor method.
     *
     * @param ProcessBuilder $processBuilder      Process builder
     * @param array          $designVariantsArray Array of DesignVariants 
     * @param string         $designsPreviewPath  Path of designs previews
     */
    public function __construct($processBuilder, $designVariantsArray, $designsPreviewPath)
    {
        $this->processBuilder = $processBuilder;
        $this->designVariantsArray = $designVariantsArray;
        $this->designsPreviewPath = $designsPreviewPath;
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

            $designFileName = $this->designsPreviewPath . '/' .
                $designVariant->getDesign()->getId() . '/0/0/'. 
                $designVariant->getDesign()->getPreviewFileName();

            $this->processBuilder->add($designFileName);
            $this->processBuilder->add('-geometry')->add('+'.$designVariant->getPosX().'+'.$designVariant->getPosY());
            $this->processBuilder->add('-composite');				
        }
        
        return $this->processBuilder;
    }
    
    
}
