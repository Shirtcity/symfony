<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Interfaces;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Text;

interface TextVariantInterface extends PrintableVariantInterface
{
    /**
     * Set text
     *
     * @param Text $text
     *
     * @return TextVariant
     */
    public function setText(Text $text);

    /**
     * Get text
     *
     * @return Text
     */
    public function getText();
}
