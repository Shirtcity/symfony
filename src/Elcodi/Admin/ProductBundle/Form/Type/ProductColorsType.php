<?php

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

/**
 * Class ProductColorsType
 */
class ProductColorsType extends AbstractType
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
				$productColors = $this
					->factory
					->create();
				
				return $productColors
					->setProduct($form->get('product')->getData())
					->setProductColor($form->get('productColor')->getData());				
			},
            'data_class' => null,
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
			->add('productColor', 'entity', [
                'class'    => $this->productColorNamespace,
                'required' => false,
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
        return 'elcodi_admin_product_form_type_product_colors';
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
