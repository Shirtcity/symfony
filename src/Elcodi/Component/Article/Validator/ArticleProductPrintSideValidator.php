<?php

namespace Elcodi\Component\Article\Validator;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ArticleProductPrintSideValidator extends ConstraintValidator
{
    private $constraint;
    
    public function validate($articleProductPrintSide, Constraint $constraint)
    {
        
    }
}