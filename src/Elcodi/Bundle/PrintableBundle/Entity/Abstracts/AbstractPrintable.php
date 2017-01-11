<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Abstracts;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableInterface;

abstract class AbstractPrintable implements PrintableInterface
{
    protected $posX;
    protected $posY;

    /**
     * @return mixed
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * @param mixed $posX
     * @return AbstractPrintable
     */
    public function setPosX($posX)
    {
        $this->posX = $posX;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * @param mixed $posY
     * @return AbstractPrintable
     */
    public function setPosY($posY)
    {
        $this->posY = $posY;
        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function getType();
}