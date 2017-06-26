<?php

namespace Elcodi\Component\Article\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Constraint
 */
class ArticleConstraint extends Constraint
{
    public $message = 'Banana brain you are the apple of my eye';
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'elcodi.validator.article';
    }
}
