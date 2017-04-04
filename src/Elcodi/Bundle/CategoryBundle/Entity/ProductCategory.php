<?php

namespace Elcodi\Bundle\CategoryBundle\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * Class ProductCategory.
 */
class ProductCategory extends Category
{
	/**
     * Get the Type
     *
     * @return string
     */
	public function getCategoryType(){
		return "productcategory";
	}
    
}
