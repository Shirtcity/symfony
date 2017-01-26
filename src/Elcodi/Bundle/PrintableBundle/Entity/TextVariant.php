<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\TextVariantInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Elcodi\Component\User\Entity\Customer;

/**
 * DesignVariant
 */
class TextVariant extends AbstractPrintable implements TextVariantInterface
{
    /**
     * Get the Type
     *
     * @return string
     */
    public function getType(){
        return 'TextVariant';
    }
}