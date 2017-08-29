<?php

namespace Elcodi\Admin\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Admin\PrintableBundle\Form\Type\TextType;
use Elcodi\Bundle\PrintableBundle\PrintableDefaultParameters;
use Elcodi\Component\Article\EventListener\Form\ArticlePrintableVariantFormEventListener;

/**
 * Class TextPrintableVariantType
 */
class TextPrintableVariantType extends AbstractType
{
    use FactoryTrait;
    

    /**
     * @var stirng
     *
     * Text Printable namespace
     */
	protected $textPrintableNamespace;
    
    /**
     * @var stirng
     *
     * Text form type
     */
	protected $textFormType;
    
   /**
     * @var ArticlePrintableVariantFormEventListener 
     * 
     * ArticlePrintableVariantFormEventListener
     */
    protected $printableVariantEventListener;
    
	
    /**
     * Construct
     *
	 * @param string   $textPrintableNamespace	Printable namespace
     * @param TextType $textFormType            Text form type
     * @param ArticlePrintableVariantFormEventListener $printableVariantEventListener Article printable variant EventListener
     */
    public function __construct(
		string $textPrintableNamespace,
        TextType $textFormType,
        ArticlePrintableVariantFormEventListener $printableVariantEventListener
    ) {
		$this->textPrintableNamespace = $textPrintableNamespace;
        $this->textFormType = $textFormType;
        $this->printableVariantEventListener = $printableVariantEventListener;
    }
	
    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {		
        $resolver->setDefaults([
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
			->add('posX',  'integer', [                
                'label' => 'PosX',
            ])
			->add('posY',  'integer', [
                'label' => 'PosY',
            ])
            ->add('width',  'integer', [
                'constraints' => [
                    new Constraints\GreaterThanOrEqual(
                        [
                            'value' => PrintableDefaultParameters::MIN_DESIGN_PRINTABLE_VARIANT_WIDTH,
                        ]
                    ),
                ],
                'label' => 'Width',
                'error_bubbling' => true,
            ])			
            ->add('text', $this->textFormType);	 

        $builder->addEventSubscriber($this->printableVariantEventListener);	
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
        return 'elcodi_admin_article_form_type_text_printable_variant';
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
