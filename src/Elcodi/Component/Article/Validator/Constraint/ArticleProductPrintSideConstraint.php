<?php

namespace Elcodi\Component\Article\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class Constraint
 */
class ArticleProductPrintSideConstraint extends Constraint
{
    public $message = "Cause I'm having the best time of my life";
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
    public function validatedBy()
    {
        return 'elcodi.validator.article_product_print_side';
    }
}
