<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * Text
 */
class Text extends AbstractPrintable implements TextInterface
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
    private $content;


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
     * Set content
     *
     * @param string $content
     *
     * @return Text
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the Type
     *
     * @return string
     */
    public function getType(){
        return 'Text';
    }
}

