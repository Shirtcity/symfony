<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\FontInterface;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

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
     * Set filename
     *
     * @param string $filename
     *
     * @return Font
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
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
}

