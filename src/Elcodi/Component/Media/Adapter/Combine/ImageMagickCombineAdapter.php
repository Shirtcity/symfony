<?php

namespace Elcodi\Component\Media\Adapter\Combine;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Process\ProcessBuilder;

use Elcodi\Component\Media\Adapter\Combine\Interfaces\CombineAdapterInterface;
use Elcodi\Component\Media\Adapter\Resizer\ImageMagickResizeAdapter;
/**
 * Class ImageMagickResizerAdapter.
 */
class ImageMagickCombineAdapter implements CombineAdapterInterface
{
    /**
     * @var string
     *
     * Path of image converter
     */
    private $imageConverterBin;

    /**
     * @var string
     *
     * Default ICC profile path
     */
    private $profile;
	
	/**
	 * @var string
	 * 
	 * Designs preview path 
	 */
	private $designsPreviewPath;
    
    /**
     * @var ProcessBuilder
     * 
     * Process builder
     */
    private $processBuilder;

    /**
     * @var File 
     * 
     * Original image file
     */
    private $originalFile;
    
    /**     
     * @var File
     * 
     * Combined image file 
     */
    private $combinedFile;
    
    /**
     * Constructor method.
     *
     * @param string $imageConverterBin  Path of image converter
     * @param string $profile            Default ICC profile path
	 * @param string $designsPreviewPath Designs preview path
     */
    public function __construct($imageConverterBin, $profile, $designsPreviewPath)
    {
        $this->imageConverterBin = $imageConverterBin;
        $this->profile = $profile;
		$this->designsPreviewPath = $designsPreviewPath;
    }

    /**
     * Generate Thumbnail images with ImageMagick.
     *
     * @param string $imageData             Image Data
     * @param array  $textVariantsArray     Texts
     * @param array  $designVariantsArray   Designs
     *
     * @return string Combined image data
     *
     * @throws \RuntimeException
     */
    public function combine(
        $imageData,
        $textVariantsArray,
		$designVariantsArray
    ) {    
        $this->createImageFilesObjects();
        
        file_put_contents($this->originalFile, $imageData);

        $this->processBuilder = new ProcessBuilder();
        
        $this
            ->setDefaultImageSettings()
            ->setTexts($textVariantsArray)
            ->setDesigns($designVariantsArray)
            ->processCombineImage();	        

        $imageContent = file_get_contents($this->combinedFile->getRealPath());

        $this->deleteImageFilesObjects();

        return $imageContent;
    }
    
    /**
     * Creates files objects
     */
    private function createImageFilesObjects()
    {
        $this->originalFile = new File(tempnam(sys_get_temp_dir(), '_original'));
        $this->combinedFile = new File(tempnam(sys_get_temp_dir(), '_resize'));
    }
    
    /**
     * Delets files objects
     */
    private function deleteImageFilesObjects()
    {
        unlink($this->originalFile);
        unlink($this->combinedFile);
    }
    
    /**
     * Sets default settings
     * 
     * @return $this
     */
    private function setDefaultImageSettings()
    {
        $this->processBuilder
            ->add($this->imageConverterBin)
            //Crop white surrounding image
            ->add($this->originalFile->getPathname())
            //We use a CMKY profile and a sRGB
            ->add('-profile')
            ->add($this->profile);
        
        return $this;
    }
    
    /**
     * Sets texts
     * 
     * @param Array $textVariantsArray
     * @return $this
     */
    private function setTexts($textVariantsArray)
    {   
        $textCombineAdapter = new TextCombineAdapter(
            $this->processBuilder, 
            $textVariantsArray
        );
        
        $this->processBuilder = $textCombineAdapter
            ->setTexts();
        
        return $this;
    }  
    
    /**
     * Sets designs
     * 
     * @param array $designVariantsArray
     * @return $this
     */
    private function setDesigns($designVariantsArray)
    {
        $resizeAdapter = new ImageMagickResizeAdapter($this->imageConverterBin, $this->profile);
        
        $designCombineAdapter = new DesignCombineAdapter(
            $this->processBuilder, 
            $designVariantsArray, 
            $this->designsPreviewPath,
            $resizeAdapter
        );
        
        $this->processBuilder = $designCombineAdapter
            ->setDesigns();
        
        return $this;        
    }
    
    /**
     * Process image combine
     * 
     * @return $this
     * @throws \RuntimeException
     */
    private function processCombineImage()
    {        
        $processor = $this->processBuilder
			->add('-resize')->add(520)
            ->add($this->combinedFile->getPathname())
            ->getProcess();
        
        $processor->run();
        
        if (false !== strpos($processor->getOutput(), 'ERROR')) {
            throw new \RuntimeException($processor->getOutput());
        }
        
        return $this;
    }
}
