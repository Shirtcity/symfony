<?php

namespace Elcodi\Bundle\CategoryBundle\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * Class SectionCategory.
 */
class SectionCategory extends Category
{
	/**
     * Get the Type
     *
     * @return string
     */
	public function getCategoryType(){
		return "sectioncategory";
	}
    
}
