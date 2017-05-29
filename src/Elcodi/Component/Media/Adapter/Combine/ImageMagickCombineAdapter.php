<?php

namespace Elcodi\Component\Media\Adapter\Combine;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Process\ProcessBuilder;

use Elcodi\Component\Media\Adapter\Combine\Interfaces\CombineAdapterInterface;
use Elcodi\Component\Media\ElcodiMediaImageResizeTypes;

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
    
    private $processBuilder;

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
     * @param string $imageData Image Data
     * @param array  $texts    Texts
     * @param array  $designs  Designs
     *
     * @return string Combined image data
     *
     * @throws \RuntimeException
     */
    public function combine(
        $imageData,
        $texts,
		$designs
    ) {
        $originalFile = new File(tempnam(sys_get_temp_dir(), '_original'));
        $resizedFile = new File(tempnam(sys_get_temp_dir(), '_resize'));

        file_put_contents($originalFile, $imageData);

        //ImageMagick params
        $this->processBuilder = new ProcessBuilder();        
        $this->setDefaultImageSettings($originalFile);      
        

		if (!empty($texts)) {
            
            $this->setTexts($texts);
			
		}		
		
		if (!empty($designs)) {
			foreach ($designs as $designVariant) {
                if ($designVariant->getDesign() === null) {
                    continue;
                }
                
				$designName = $this->designsPreviewPath . '/' .
					$designVariant->getDesign()->getId() . '/0/0/'. 
					$designVariant->getDesign()->getPreviewFileName();
				
				$this->processBuilder->add($designName);
				$this->processBuilder->add('-geometry')->add('+'.$designVariant->getPosX().'+'.$designVariant->getPosY());
				$this->processBuilder->add('-composite');				
			}
		}

        $proc = $this->processBuilder
			->add('-resize')->add(200)
            ->add($resizedFile->getPathname())
            ->getProcess();

        $proc->run();

        if (false !== strpos($proc->getOutput(), 'ERROR')) {
            throw new \RuntimeException($proc->getOutput());
        }

        $imageContent = file_get_contents($resizedFile->getRealPath());

        unlink($originalFile);
        unlink($resizedFile);

        return $imageContent;
    }
    
    private function setDefaultImageSettings($originalFile)
    {
        $this->processBuilder
            ->add($this->imageConverterBin)
            //Crop white surrounding image
            ->add($originalFile->getPathname())
            //We use a CMKY profile and a sRGB
            ->add('-profile')
            ->add($this->profile);
        
        return $this;
    }
    
    private function setTexts($texts)
    {
        foreach ($texts as $textVariant) { 
            
            if ( null === $textVariant->getText()) {
                continue;
            }
            
            $this
                ->setFoilColor($textVariant)
                ->setFont($textVariant)
                ->setPosition($textVariant)
                ->setFontSize()
                ->setTextContent($textVariant);
        }
        
        return $this;
    }
    
    private function setFoilColor($textVariant)
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
    
    private function setFont($textVariant)
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
    
    private function setPosition($textVariant)
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
    
    private function setFontSize()
    {
        $this->processBuilder
            ->add('-weight')
            ->add(14);

        $this->processBuilder
            ->add('-pointsize')
            ->add(20);
        
        return $this;
    }
    
    private function setTextContent($textVariant)
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
