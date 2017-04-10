<?php
namespace Elcodi\Bundle\PrintableBundle\VichUploader\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Design;

/**
 * DesignDirectoryNamer
 *
 * @author Tobias Strunz <t.strunz@shirtcity.com>
 */
class DesignDirectoryNamer implements DirectoryNamerInterface
{
    /**
    * Returns the name of a directory where files will be uploaded
    *
    * Directory name is formed based on user ID
    *
    * @param Design $design
    * @param PropertyMapping $mapping
    *
    * @return string
    */
    public function directoryName($design, PropertyMapping $mapping)
    {
       /* $file = $mapping->getFile($design);
        $extension = $file->getClientOriginalExtension();
        */

        $layer = array(1 => '0', 2 => '0', 3 => '0');

        $id = $design->getId();
        $number = (string)$id;
        $start = strlen($number);
        for($i = 1; $i < 4; $i++){
            if(isset($number[ $start - $i])){
                $layer[$i] = $number[ $start - $i];
            }

        }

        return implode($layer, '/') . '/';
    }
}
