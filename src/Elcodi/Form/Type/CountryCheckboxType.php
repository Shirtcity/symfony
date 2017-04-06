<?php
namespace Elcodi\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CountryCheckboxType extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }

    public function getName()
    {
        return 'country_checkbox';
    }
}