<?php

namespace Elcodi\Bundle\PrintableBundle\Entity;

use Elcodi\Bundle\PrintableBundle\Entity\PrintableVariant;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\DesignVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Design;

/**
 * DesignVariant
 */
class DesignVariant extends PrintableVariant implements DesignVariantInterface
{


    /**
     * @var Design
     */
    private $design;


    /**
     * Set design
     *
     * @param Design $design
     *
     * @return DesignVariant
     */
    public function setDesign(Design $design = null)
    {
        $this->design = $design;

        return $this;
    }

    /**
     * Get design
     *
     * @return Design
     */
    public function getDesign()
    {
        return $this->design;
    }
}
