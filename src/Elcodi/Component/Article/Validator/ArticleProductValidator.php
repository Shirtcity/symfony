<?php

namespace Elcodi\Component\Article\Validator;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ArticleProductValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /*$this->context->buildViolation($constraint->message)
            ->setParameter('{{ printableType }}', $value->getId())
            ->addViolation();*/
    }
}