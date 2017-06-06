<?php
namespace Elcodi\Bundle\PrintableBundle\Entity\Interfaces;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Design;

interface DesignVariantInterface extends PrintableVariantInterface
{
    /**
     * Set design
     *
     * @param Design $design
     *
     * @return DesignVariant
     */
    public function setDesign(Design $design);

    /**
     * Get design
     *
     * @return Design
     */
    public function getDesign();
}