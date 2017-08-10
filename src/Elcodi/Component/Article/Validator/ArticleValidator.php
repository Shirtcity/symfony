<?php

namespace Elcodi\Component\Article\Validator;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ArticleValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        
    }
}