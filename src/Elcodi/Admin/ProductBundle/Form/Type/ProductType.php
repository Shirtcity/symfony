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

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

use Elcodi\Form\Type\EntityColorType;

use Yokai\ManyToManyMatrixBundle\Form\Type\ManyToManyMatrixType;

/**
 * Class ProductType
 */
class ProductType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;
	
	/**
     * @var string
     *
     * ProductSize namespace
     */
	protected $sizeNamespace;
	
	/**
     * @var string
     *
     * ProductColor namespace
     */
	protected $colorNamespace;
	
	/**
     * @var string
     *
     * ProductSizes namespace
     */
	protected $sizesNamespace;
	
	/**
     * @var string
     *
     * Manufacturer namespace
     */
	protected $manufacturerNamespace;
	
	/**
     * @var string
     *
     * Category namespace
     */
	protected $categoryNamespace;
	
	/**
     * @var string
     *
     * PrintSide namespace
     */
	protected $printSideNamespace;
	
	/**
     * @var string
     *
     * Price namespace
     */
	protected $priceNamespace;
	
	/**
     * @var string
     *
     * ProductColorsType namespace
     */
	protected $productColorsType;

	/**
     * Construct
     *
	 * @param string $sizeNamespace				ProductSize namespace
	 * @param string $colorNamespace			ProductColor namespace
     * @param string $sizesNamespace			ProductSizes namespace
     * @param string $imageNamespace			Image namespace
	 * @param string $manufacturerNamespace		Manufacturer namespace
	 * @param string $categoryNamespace			Category namespace
	 * @param string $printSideNamespace		PrintSide namespace
	 * @param string $priceNamespace			Price namespace
	 * @param string $productColorsType			ProductColorsType namespace
     */
    public function __construct(
        $imageNamespace,
		$sizeNamespace,
		$colorNamespace,
		$sizesNamespace,
		$manufacturerNamespace,
		$categoryNamespace,
		$printSideNamespace,
		$priceNamespace,
		$productColorsType
    ) {
        $this->imageNamespace = $imageNamespace;
		$this->sizeNamespace = $sizeNamespace;
		$this->colorNamespace = $colorNamespace;
		$this->sizesNamespace = $sizesNamespace;
		$this->manufacturerNamespace = $manufacturerNamespace;
		$this->categoryNamespace = $categoryNamespace;
		$this->printSideNamespace = $printSideNamespace;
		$this->priceNamespace = $priceNamespace;
		$this->productColorsType = $productColorsType;
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
            ->add('name', 'text', [
                'required'    => true,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('slug', 'text', [
                'required' => true,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('description', 'textarea', [
                'required' => true,
            ])
			->add('prices', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', [
				'entry_type' => 'money_object',				
                'required' => true,		
            ])
            ->add('imagesSort', 'text', [
                'required' => false,
            ])			
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('height', 'number', [
                'required' => false,
            ])
            ->add('width', 'number', [
                'required' => false,
            ])
            ->add('weight', 'number', [
                'required' => false,
            ])
            ->add('product_manufacturer', 'entity', [
                'class'    => $this->manufacturerNamespace,
                'required' => false,
                'multiple' => false,
            ])
			/*
            ->add('principalCategory', 'entity', [
                'class'    => $this->categoryNamespace,
                'required' => true,
                'multiple' => false,
            ])
			 * 
			 */
            ->add('images', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'property' => 'id',
                'multiple' => true,
                'expanded' => true,
            ])
			->add('productSizes', 'entity', [
                'class'    => $this->sizeNamespace,
                'required' => false,
                'property' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
			->add('productColors', 'entity_color', [
                'class'    => $this->colorNamespace,
                'required' => false,
                'property' => 'code',
                'multiple' => true,
                'expanded' => true,
            ])				
			/**
			->add('sizes', 'Yokai\ManyToManyMatrixBundle\Form\Type\ManyToManyMatrixType', [
                'class'    => $this->sizesNamespace,
                'required' => false,
				'association' => 'colors',
				//'by_reference' => false,
				//'label' => false,
                //'multiple' => true,
				//'property' => 'id',
				//'choice_label' => 'size.name',
				//'expanded' => true,
            ])
			 * 
			 */
			->add('print_sides', 'entity', [
                'class'    => $this->printSideNamespace,
                'required' => false,
                'property' => 'position',
                'multiple' => true,
                'expanded' => true,
            ]);
		
        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
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
        return 'elcodi_admin_product_form_type_product';
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
