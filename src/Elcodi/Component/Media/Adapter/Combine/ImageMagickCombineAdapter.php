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
     * Constructor method.
     *
     * @param string $imageConverterBin Path of image converter
     * @param string $profile           Default ICC profile path
     */
    public function __construct($imageConverterBin, $profile)
    {
        $this->imageConverterBin = $imageConverterBin;
        $this->profile = $profile;
    }

    /**
     * Generate Thumbnail images with ImageMagick.
     *
     * @param string $imageData Image Data
     * @param int    $height    Height value
     * @param int    $width     Width value
     * @param int    $type      Type
     *
     * @return string Resized image data
     *
     * @throws \RuntimeException
     */
    public function combine(
        $imageData,
        $text,
		$design
    ) {
        $originalFile = new File(tempnam(sys_get_temp_dir(), '_original'));
        $resizedFile = new File(tempnam(sys_get_temp_dir(), '_resize'));

        file_put_contents($originalFile, $imageData);

        //ImageMagick params
        $pb = new ProcessBuilder();
        $pb
            ->add($this->imageConverterBin)
            //Crop white surrounding image
            ->add($originalFile->getPathname())
            //We use a CMKY profile and a sRGB
            ->add('-profile')
            ->add($this->profile);

		if (!empty($text)) {
			foreach ($text as $textVariant) {
				// set text color
				$pb->add('-fill')->add($textVariant->getText()->getFoilColor()->getCode());
				// set font
				$pb->add('-font')->add($textVariant->getText()->getFont()->getName());
				// set coords start point
				$pb->add('-gravity')->add('NorthWest');
				// set font size
				$pb->add('-weight')->add(14);
				$pb->add('-pointsize')->add(20);
				// set coords and text
				$pb
					->add('-annotate')
					->add('+'.$textVariant->getPosX().'+'.$textVariant->getPosY())
					->add($textVariant->getText()->getContent());
				
			}
		}		
		
		if (!empty($design)) {
			foreach ($design as $designVariant) {
				$designPath = '/srv/www/shirtcity.dev2/files/design/preview/';
				$designName = $designPath . $designVariant->getDesign()->getId() . '/0/0/'. $designVariant->getDesign()->getPreviewFileName();
			
				$pb->add($designName);
				$pb->add('-geometry')->add('+'.$textVariant->getPosX().'+'.$textVariant->getPosY());
				$pb->add('-composite');				
			}
		}

        $proc = $pb
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
}
