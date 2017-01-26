<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\Abstracts\AbstractPrintable;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignVariantInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Bundle\PrintableBundle\Entity\FoilColor;
use Elcodi\Component\User\Entity\Customer;

/**
 * DesignVariant
 */
class DesignVariant extends AbstractPrintable implements DesignVariantInterface
{
    /**
     * Get the Type
     *
     * @return string
     */
    public function getType(){
        return 'DesignVariant';
    }
}
