<?php

namespace Elcodi\Admin\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Bundle\CategoryBundle\Repository\CategoryRepository;

/**
 * Class CategoryType
 */
class CategoryType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

	/**
	 * @var string 
	 * 
	 * Form name
	 */
	private $formName;
	
	/**
	 * Construct 
	 * 
	 * @param string $formName form name
	 */
	public function __construct($formName = 'elcodi_admin_article_form_type_category') {
		$this->formName = $formName;
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
		$formData = $builder->getData();		

        $currentCategoryId = $formData->getId();

        $categoryNamespace = $this
            ->factory
            ->getEntityNamespace();

        $builder
            ->add('name', 'text', [
                'required' => true,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('slug', 'text', [
                'required' => false,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('root', 'checkbox', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
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
            ->add('parent', 'entity', [
                'class'         => $categoryNamespace,
                'query_builder' => $this->getAvailableCategories($currentCategoryId),
                'required'      => true,
                'multiple'      => false,
            ]);

        $builder->addEventSubscriber($this->getEntityTranslatorFormEventListener());
    }

    /**
     * This method returns a closure used to show only the valid categories to
     * be selected as parent.
     *
     * @param integer|null $currentCategoryId The current category id
     *
     * @return callable
     */
    protected function getAvailableCategories($currentCategoryId)
    {
        return function (CategoryRepository $categoryRepository) use ($currentCategoryId) {

            return $categoryRepository->getAvailableParentCategoriesQueryBuilder($currentCategoryId);
        };
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
        return 'elcodi_admin_article_form_type_category';
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
        return $this->formName;
    }
}
