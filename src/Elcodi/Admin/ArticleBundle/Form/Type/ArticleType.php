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

namespace Elcodi\Admin\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

use Elcodi\Admin\ArticleBundle\Validation\MinimumMoney;
use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class ArticleType
 */
class ArticleType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
    /**
     * @var string
     *
     * Category namespace
     */
    protected $categoryNamespace;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;
	
	/**
     * @var string
     *
     * ArticleProductInterface namespace
     */
    protected $articleProductNamespace;
	
	protected $articleProductType;

    /**
     * Construct
     *
     * @param string $categoryNamespace     Category namespace
     * @param string $imageNamespace        Image namespace
	 * @param ArticleProductType $articleProductType	Article product form type
     */
    public function __construct(
        $categoryNamespace,
        $imageNamespace,
		$articleProductType
    ) {
        $this->categoryNamespace = $categoryNamespace;
        $this->imageNamespace = $imageNamespace;
		$this->articleProductType = $articleProductType;
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
			'cascade_validation' => true,
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
            ->add('showInHome', 'checkbox', [
                'required' => false,
            ])
            ->add('stock', 'hidden', [
                'required' => true,
            ])
            ->add('sku', 'text', [
                'required' => false,
            ])
            ->add('price', 'money_object', [
                'required' => true,
                'constraints' => [
                    new MinimumMoney([
                        'value' => 0,
                    ]),
                ],
            ])
            ->add('reducedPrice', 'money_object', [
                'required' => false,
                'constraints' => [
                    new MinimumMoney([
                        'value' => 0,
                    ]),
                ],
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
            ->add('depth', 'number', [
                'required' => false,
            ])
            ->add('weight', 'number', [
                'required' => false,
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
            ])
            ->add('metaDescription', 'text', [
                'required' => false,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 159,
                        ]
                    ),
                ],
            ])
            ->add('metaKeywords', 'text', [
                'required' => false,
            ])
            ->add('stock', 'number', [
                'required' => false,
            ])
            ->add('principalCategory', 'entity', [
                'class'    => $this->categoryNamespace,
                'required' => true,
                'multiple' => false,
            ])
			->add('articleProduct', $this->articleProductType, [
				'required' => true,
			])				
            ->add('images', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'property' => 'id',
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
        return 'elcodi_admin_article_form_type_article';
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
