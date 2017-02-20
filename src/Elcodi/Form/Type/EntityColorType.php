<?php
namespace Elcodi\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntityColorType extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }

    public function getName()
    {
        return 'entity_color';
    }
}