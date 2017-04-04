<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Elcodi\Component\User\Entity\Customer;

/**
 * Design
 */
class Design extends AbstractPrintable implements DesignInterface
{
    use DateTimeTrait,
        EnabledTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $foilcolor;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var string
     */
    private $vectorFileName;

    /**
     * @var string
     */
    private $previewFileName;

    /**
     * @var File $vectorFile
     */
    private $vectorFile;

    /**
     * @var File $previewFile
     */
    private $previewFile;

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
     * @return Design
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
     * Get the Type
     *
     * @return string
     */
    public function getType(){
        return 'Design';
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
     * Constructor
     */
    public function __construct()
    {
        $this->foilcolor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add foilcolor
     *
     * @param FoilColor $foilcolor
     *
     * @return Design
     */
    public function addFoilcolor(FoilColor $foilcolor)
    {
        $this->foilcolor[] = $foilcolor;

        return $this;
    }

    /**
     * Remove foilcolor
     *
     * @param FoilColor $foilcolor
     */
    public function removeFoilcolor(FoilColor $foilcolor)
    {
        $this->foilcolor->removeElement($foilcolor);
    }

    /**
     * Get foilcolor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFoilcolor()
    {
        return $this->foilcolor;
    }


    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return Design
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set vectorFileName
     *
     * @param string $vectorFileName
     *
     * @return Font
     */
    public function setVectorFileName($vectorFileName)
    {
        $this->vectorFileName = $vectorFileName;

        return $this;
    }

    /**
     * Get vectorFileName
     *
     * @return string
     */
    public function getVectorFileName()
    {
        return $this->vectorFileName;
    }

    /**
     * Set previewFileName
     *
     * @param string $previewFileName
     *
     * @return Design
     */
    public function setPreviewFileName($previewFileName)
    {
        $this->previewFileName = $previewFileName;

        return $this;
    }

    /**
     * Get previewFileName
     *
     * @return string
     */
    public function getPreviewFileName()
    {
        return $this->previewFileName;
    }


    /**
     * @param File $vector
     *
     * @return $this
     */
    public function setVectorFile(File $vectorFile)
    {
        $this->vectorFile = $vectorFile;

        return $this;
    }

     /**
     * @Assert\File(
     *     mimeTypes = {"image/png", "application/octet-stream", "application/postscript"},
     * )
     */
    public function getVectorFile()
    {
        return $this->vectorFile;
    }

    /**
     * @param File $preview
     *
     * @return $this
     */
    public function setPreviewFile(File $previewFile)
    {
        $this->previewFile = $previewFile;

        return $this;
    }

    /**
     * @Assert\File(
     *     mimeTypes = {"image/png"},
     * )
     */
    public function getPreviewFile()
    {
        return $this->previewFile;
    }
}
