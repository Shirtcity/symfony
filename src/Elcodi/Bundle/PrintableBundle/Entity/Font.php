<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FontInterface;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Symfony\Component\HttpFoundation\File\File;

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
     * @var File $font
     */
    protected $font;


    public function __toString()
    {
        return $this->name ? $this->name : '';
    }

    /**
     * @var string
     */
    private $file_name;


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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Font
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
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


    public function setFont(File $font)
    {
        $this->font = $font;

        return $this;
    }

    public function getFont()
    {
        return $this->font;
    }

}
