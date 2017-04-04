<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Admin\PrintableBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Admin\PrintableBundle\Form\EventListener\DesignCustomerListener;


/**
 * Class DesignType
 */
class DesignType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;


    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

    /**
     * Construct
     *
     * @param string $manufacturerNamespace Manufacturer namespace
     */
    public function __construct() {
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => function () {
                $this
                    ->factory
                    ->create();
            },
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
        ]);
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required'    => true
            ])
            ->add('customer', EntityType::class, [
                'class' => 'Elcodi\Component\User\Entity\Customer',
                'choice_label' => 'email'
            ])
            ->add('foilcolor', EntityType::class, [
                'class' => 'Elcodi\Bundle\PrintableBundle\Entity\FoilColor',
                'choice_label' => function($foilcolor) {
                    $name = $foilcolor->getName();
                    $code = $foilcolor->getCode();
                    return $name. " ({$code})";
                },
                'multiple' => true,
                'expanded' => true
            ])
             ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('vectorFile', VichFileType::class, [
                'required'    => false,
                'allow_delete' => true,
                'download_link' => true
            ])
            ->add('previewFile', VichImageType::class, [
                'required'    => false,
                'allow_delete' => true,
                'download_link' => true
            ]);
		
        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
        $builder->addEventSubscriber(new DesignCustomerListener());
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'elcodi_admin_printable_form_type_design';
    }

    /**
     * Return unique name for this form
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed from Symfony 3.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
