<?php

namespace Elcodi\Admin\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
	
	/**
	 * @var $articleProductType 
	 * 
	 * ArticleProductType FormType
	 */
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
                'required'    => false,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('slug', 'text', [
                'required'    => false,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('showInHome', 'checkbox', [
                'required' => false,
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('metaTitle', 'text', [
                'required' => false,
            ])
            ->add('metaDescription', 'text', [
                'required'    => false,
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
			->add('articleProduct', $this->articleProductType);

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
