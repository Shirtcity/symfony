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
use Elcodi\Bundle\PrintableBundle\PrintableDefaultParameters;
use Elcodi\Component\Article\EventListener\Form\ArticlePrintableVariantFormEventListener;


/**
 * Class DesignPrintableVariantType
 */
class DesignPrintableVariantType extends AbstractType
{
    use FactoryTrait;
    

    /**
     * @var stirng
     *
     * Design namespace
     */
	protected $designNamespace;
    
    /**
     * @var ArticlePrintableVariantFormEventListener 
     * 
     * ArticlePrintableVariantFormEventListener
     */
    protected $printableVariantEventListener;
	
    /**
     * Construct
     *
	 * @param string $designNamespace	Design namespace
     * @param ArticlePrintableVariantFormEventListener $printableVariantEventListener Article printable variant EventListener
     */
    public function __construct(
		$designNamespace,
        ArticlePrintableVariantFormEventListener $printableVariantEventListener
    ) {
		$this->designNamespace = $designNamespace;
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
                'label'             => 'Width',
                'error_bubbling'    => true,
            ])
            ->add('design', 'entity',[
                'class'			=> $this->designNamespace,
                'choice_label'	=> 'name',
                'label'         => 'Design',
            ]);
        
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
        return 'elcodi_admin_article_form_type_design_printable_variant';
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
