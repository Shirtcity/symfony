<?php

namespace Elcodi\Component\Core\Entity\Traits;

/**
 * trait for DateTime common variables and methods.
 */
trait ExistsTrait
{
    /**
	 * Check if record is already exist.
	 * 
	 * @return bool
	 */
	public function exists(bool $exists = false)
	{
		return $this->id ? true : false;
	}
}
