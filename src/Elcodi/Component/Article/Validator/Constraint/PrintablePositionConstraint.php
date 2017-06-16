<?php

namespace Elcodi\Component\Article\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Constraint
 */
class PrintablePositionConstraint extends Constraint
{
    public $messageWrongPosition = "{{ printableType }} \"{{ printableName }}\" doesn't fit to any of print areas. The print position has been corrected.";
    public $messagePrintableResized = "{{ printableType }} \"{{ printableName }}\" was too big and has been resized.";
    public $messagePrintableNotResized = "{{ printableType }} \"{{ printableName }}\" is too big and can't be resized. Please move it to a correct position.";
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'elcodi.validator.article.printable_position';
    }
}
