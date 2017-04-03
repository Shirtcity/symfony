<?php
namespace Elcodi\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ColorCheckboxType extends AbstractType
{

    public function getParent()
    {
        return CheckboxType::class;
    }

    public function getName()
    {
        return 'color_checkbox';
    }
}