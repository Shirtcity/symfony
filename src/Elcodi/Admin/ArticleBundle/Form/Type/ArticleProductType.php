<?php

namespace Elcodi\Admin\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class ArticleType
 */
class ArticleProductType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
    /**
     * @var string
     *
     * Category namespace
     */
    protected $productNamespace;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $productColorNamespace;
	
    /**
     * Construct
     *
	 * @param string $productNamespace		Product namespace
	 * @param string $productColorNamespace	ProductColor namespace
     */
    public function __construct(
		$productNamespace,
		$productColorNamespace
    ) {
        $this->productNamespace = $productNamespace;
		$this->productColorNamespace = $productColorNamespace;		
    }
	
    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {		
        $resolver->setDefaults([
			'empty_data' => function(FormInterface $form) {
				$articleProduct = $this
					->factory
					->create();
				
				return $articleProduct
					->setProduct($form->get('product')->getData())
					->setProductColor($form->get('productColor')->getData());				
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
			->add('product', 'entity', [
                'class'    => $this->productNamespace,
                'required' => true,
                'multiple' => false
            ]);
		
		$formModifier = function (FormInterface $form, $articleProduct = null) {
            $colors = null === $articleProduct ? array() : $articleProduct->getProductColors();

            $form->add('productColor', 'entity', [
                'class'     => $this->productColorNamespace,
                'required'	=> true,
                'choices'   => $colors,
            ]);
        };
		
		$builder->addEventListener(
			FormEvents::PRE_SET_DATA, 
			function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
				
                $formModifier($event->getForm(), $data->getProduct());
            }
        );

        $builder->get('product')->addEventListener(
			FormEvents::POST_SUBMIT, 
			function (FormEvent $event) use ($formModifier) {
                $articleProduct = $event->getForm()->getData();
				
                $formModifier($event->getForm()->getParent(), $articleProduct);
            }
        );			
		
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
        return 'elcodi_admin_article_form_type_article_product';
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
	
	/**
     * To string method.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
