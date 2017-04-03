<?php

namespace Elcodi\Bundle\CategoryBundle\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * Class DesignCategory.
 */
class DesignCategory extends Category
{
	/**
     * Get the Type
     *
     * @return string
     */
	public function getCategoryType(){
		return "designcategory";
	}
    
}
