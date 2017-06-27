<?php

namespace Elcodi\Fixtures\DataFixtures\ORM\Product\Abstracts;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Bundle\MediaBundle\DataFixtures\ORM\Traits\ImageManagerTrait;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideProductColorsInterface;

/**
 * Class AbstractPrintSideProductColorsData
 */
abstract class AbstractPrintSideProductColorsData extends AbstractFixture
{
    use ImageManagerTrait;

    /**
     * Steps necessary to store an image
     *
     * @param PrintSideProductColorsInterface   $printSideProductColors PrintSideProductColors
     * @param string                            $imageName   Image name
     *
     * @return $this Self object
     */
    protected function storePrintSideProductColorsImage(
        PrintSideProductColorsInterface $printSideProductColors,
        $imageName
    ) {
        $imagePath = realpath(__DIR__ . '/../images/' . $imageName);
        $image = $this->storeImage($imagePath);

        $printSideProductColors->setImage($image);

        return $this;
    }
}
