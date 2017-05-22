<?php

namespace Elcodi\Admin\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;
use Elcodi\Component\Article\EventListener\Form\ArticleProductFormEventListener;
use Elcodi\Admin\ArticleBundle\Form\Type\ArticleProductPrintSideType;
use Elcodi\Component\Article\EventListener\Form\ArticleProductPrintSidesFormEventListener;

/**
 * Class ArticleProductType
 */
class ArticleProductType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
    /**
     * @var string
     *
     * Product namespace
     */
    protected $productNamespace;

    /**
     * @var string
     *
     * Product Color namespace
     */
    protected $productColorNamespace;
	
	/**
	 * @var ArticleProductFormEventListener
	 *  
	 * Article Product Form Event Listener
	 */
	protected $articleProductEventListener;
	
	/**
	 * @var ArticleProductPrintSideType 
	 * 
	 * Article product print side type
	 */
	protected $articleProductPrintSideType;
	
    /**
     * Construct
     *
	 * @param string $productNamespace		Product namespace
	 * @param string $productColorNamespace	ProductColor namespace
	 * @param ArticleProductFormEventListener $articleProductEventListener ArticleProductForm event listener
	 * @param ArticleProductPrintSideType $articleProductPrintSideType article product print side type
     */
    public function __construct(
		$productNamespace,
		$productColorNamespace,
		ArticleProductFormEventListener $articleProductEventListener,
		ArticleProductPrintSideType $articleProductPrintSideType
    ) {
        $this->productNamespace = $productNamespace;
		$this->productColorNamespace = $productColorNamespace;		
		
		$this->articleProductEventListener = $articleProductEventListener;
        
		$this->articleProductPrintSideType = $articleProductPrintSideType;
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
			'allow_extra_fields' => true,
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
			])
			->add('articleProductPrintSides', 'collection', [
				'entry_type' => $this->articleProductPrintSideType,
				'allow_extra_fields' => true,
			]);		
		
		$formModifier = function (FormInterface $form, $product = null) {			
            $form->add('productColors', 'entity', [
                'class'			=> $this->productColorNamespace,
                'required'		=> true,
                'choices'		=> (null === $product) ? [] : $product->getColors(),
				'choice_label'	=> 'color'
            ]);
			
        };		
		
		$builder
			->addEventListener(	FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {				
				$product = (null === $event->getData()) ? null : $event->getData()->getProduct();
				$formModifier($event->getForm(), $product);
			});			
		
        $builder
			->get('product')
			->addEventListener(	FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
				$product = $event->getForm()->getData();					
				$formModifier($event->getForm()->getParent(), $product);
			});
			
		$builder
			->addEventSubscriber($this->articleProductEventListener);
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
