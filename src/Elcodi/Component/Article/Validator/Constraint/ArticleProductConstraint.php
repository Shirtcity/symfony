<?php

namespace Elcodi\Component\Article\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Constraint
 */
class ArticleProductConstraint extends Constraint
{
    public $message = 'Stay with me tonight';
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'elcodi.validator.article_product';
    }
}
