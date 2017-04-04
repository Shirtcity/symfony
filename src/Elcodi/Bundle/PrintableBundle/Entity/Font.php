<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FontInterface;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Font
 */
class Font implements FontInterface
{
    use EnabledTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var integer
     */
    private $minSize;


    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var File $fontFile
     */
    protected $fontFile;


    public function __toString()
    {
        return $this->name ? $this->name : '';
    }

    /**
     * @var string
     */
    private $fontFileName;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Font
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set fontFileName
     *
     * @param string $fontFileName
     *
     * @return Font
     */
    public function setFontFileName($fontFileName)
    {
        $this->fontFileName = $fontFileName;

        return $this;
    }

    /**
     * Get fontFileName
     *
     * @return string
     */
    public function getFontFileName()
    {
        return $this->fontFileName;
    }

    /**
     * Set minSize
     *
     * @param integer $minSize
     *
     * @return Font
     */
    public function setMinSize($minSize)
    {
        $this->minSize = $minSize;

        return $this;
    }

    /**
     * Get minSize
     *
     * @return integer
     */
    public function getMinSize()
    {
        return $this->minSize;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param File $font
     *
     * @return $this
     */
    public function setFontFile(File $fontFile)
    {
        $this->fontFile = $fontFile;

        return $this;
    }

    public function setUpdatedAt( \DateTime $date ){
        $this->updatedAt = $date;
    }

    /**
     * @Assert\File(
     *     mimeTypes = {"font/ttf", "application/x-font-ttf"},
     *     mimeTypesMessage = "Please upload a valid Font"
     * )
     */
    public function getFontFile()
    {
        return $this->fontFile;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context){
        /*
        $valid_font_file_extensions = array('ttf');
        $font_file_extension = $this->font->getClientOriginalExtension();
        if( !in_array($font_file_extension,$valid_font_file_extensions)){
            $context
                ->buildViolation('Falscher Dateityp')
                ->atPath('font')
                ->addViolation()
            ;
        }
        */
    }
}
