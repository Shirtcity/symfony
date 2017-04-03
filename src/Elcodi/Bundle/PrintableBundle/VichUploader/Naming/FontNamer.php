<?php

namespace Elcodi\Bundle\PrintableBundle\VichUploader\Naming;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Util\Transliterator;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\ConfigurableInterface;

/**
 * FontNamer
 *
 * @author Tobias Strunz <t.strunz@shirtcity.com>
 */
class FontNamer implements NamerInterface, ConfigurableInterface
{
    /**
     * @var bool
     */
    private $transliterate = false;

    /**
     * @param array $options Options for this namer. The following options are accepted:
     *                         - transliterate: whether the filename should be transliterated or not.
     */
    public function configure(array $options)
    {
        $this->transliterate = isset($options['transliterate']) ? (bool) $options['transliterate'] : $this->transliterate;
    }

    /**
     * {@inheritDoc}
     */
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $name = $file->getClientOriginalName();

        if ($this->transliterate) {
            $name = Transliterator::transliterate($name);
        }

        $id = $object->getId();
        return $id . '_font_' .$name;
    }
}
