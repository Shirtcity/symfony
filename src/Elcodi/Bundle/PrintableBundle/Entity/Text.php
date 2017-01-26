<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Elcodi\Bundle\PrintableBundle\Entity\Font;

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
    /**
     * @var Font
     */
    private $font;

    /**
     * @var FoilColor
     */
    private $foilcolor;


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
     * Set font
     *
     * @param Font $font
     *
     * @return Text
     */
    public function setFont(Font $font = null)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get font
     *
     * @return Font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set foilcolor
     *
     * @param FoilColor $foilcolor
     *
     * @return Text
     */
    public function setFoilcolor(FoilColor $foilcolor = null)
    {
        $this->foilcolor = $foilcolor;

        return $this;
    }

    /**
     * Get foilcolor
     *
     * @return FoilColor
     */
    public function getFoilcolor()
    {
        return $this->foilcolor;
    }
}
