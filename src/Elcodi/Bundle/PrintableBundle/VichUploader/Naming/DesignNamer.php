<?php

namespace Elcodi\Bundle\PrintableBundle\VichUploader\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\ConfigurableInterface;

/**
 * DesignNamer
 *
 * @author Tobias Strunz <t.strunz@shirtcity.com>
 */
class DesignNamer implements NamerInterface, ConfigurableInterface
{
    public function configure(array $options)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $extension = $file->getClientOriginalExtension();

        $id = $object->getId();
        return $id . '.' . $extension;
    }
}
