<?php
namespace Elcodi\Admin\PrintableBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ColorPickerType extends AbstractType
{

    public function getParent()
    {
        return TextType::class;
    }

    public function getName()
    {
        return 'colorpicker';
    }
}