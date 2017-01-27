<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Text;

/**
 *TextVariant
 */
class TextVariant extends PrintableVariant implements TextVariantInterface
{

    /**
     * @var Text
     */
    private $text;


    /**
     * Set text
     *
     * @param Text $text
     *
     * @return TextVariant
     */
    public function setText(Text $text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return Text
     */
    public function getText()
    {
        return $this->text;
    }
}
