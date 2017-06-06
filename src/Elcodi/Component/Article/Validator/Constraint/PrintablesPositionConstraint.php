<?php

namespace Elcodi\Component\Article\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Constraint
 */
class PrintablesPositionConstraint extends Constraint
{
    public $messageWrongPosition = "{{ printableType }} \"{{ printableName }}\" doesn't fit to any of print areas. The print position has been corrected.";
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'elcodi.validator.article.printables_position';
    }
}
