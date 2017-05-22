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
use Elcodi\Component\Article\EventListener\Form\ArticleProductPrintSideFormEventListener;
use Elcodi\Admin\ArticleBundle\Form\Type\DesignPrintableVariantType;
use Elcodi\Admin\ArticleBundle\Form\Type\TextPrintableVariantType;


/**
 * Class ArticleProductPrintSideType
 */
class ArticleProductPrintSideType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
    /**
     * @var DesignPrintableVariantType
     *
     * Design Printable variant form type
     */
	protected $designPrintableVariantType;
    
    /**
     * @var TextPrintableVariantType
     *
     * Text Printable variant form type
     */
	protected $textPrintableVariantType;	
	
    /**
     * Construct
     *
	 * @param DesignPrintableVariantType $designPrintableVariantType Design Printable variant form type
     * @param TextPrintableVariantType $textPrintableVariantType Design Printable variant form type
     */
    public function __construct(
		DesignPrintableVariantType $designPrintableVariantType,
        TextPrintableVariantType $textPrintableVariantType
    ) {		
		$this->designPrintableVariantType = $designPrintableVariantType;
        $this->textPrintableVariantType = $textPrintableVariantType;
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
			->add('designPrintableVariants', 'collection', [
				'entry_type'    => $this->designPrintableVariantType,
				'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
			])
            ->add('textPrintableVariants', 'collection', [
				'entry_type'    => $this->textPrintableVariantType,
				'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
			]);
		
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
