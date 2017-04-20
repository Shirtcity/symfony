<?php

namespace Elcodi\Admin\PrintableBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

use Elcodi\Admin\PrintableBundle\Form\Type\TextType;
use Elcodi\Bundle\PrintableBundle\Entity\TextVariant;
use Elcodi\Bundle\PrintableBundle\Entity\DesignVariant;

/**
 * Class PrintableVariantType
 */
class PrintableVariantType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
    /**
     * @var TextType
     *
     * Printable text form type
     */
    protected $printableTextType;

    /**
     * @var stirng
     *
     * Printable design namespace
     */
	protected $printableDesignNamespace;
	
    /**
     * Construct
     *
	 * @param TextType	$printableTextType			Printable text form type
	 * @param string	$printableDesignNamespace	Printable design namespace
     */
    public function __construct(
		TextType $printableTextType,
		string $printableDesignNamespace
    ) {
		
		$this->printableTextType = $printableTextType;
		$this->printableDesignNamespace = $printableDesignNamespace;
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
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
			->add('posY',  'integer', [
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ]);
		
		$builder
			->addEventListener(	FormEvents::PRE_SET_DATA, function (FormEvent $event){
				
				$printable = $event->getData();
				$form = $event->getForm();

				if($printable instanceof TextVariant){
					
					$form->add('text', $this->printableTextType);
					
				} elseif ($printable instanceof DesignVariant){
					
					$form->add('design', 'entity',[
						'class'			=> $this->printableDesignNamespace,
						'choice_label'	=> 'name',
					]);
				}				
			});
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
        return 'elcodi_admin_article_form_type_article_product_print_side';
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
