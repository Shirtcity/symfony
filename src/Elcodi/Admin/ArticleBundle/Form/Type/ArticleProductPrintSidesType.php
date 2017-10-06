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
 * Class ArticleProductPrintSidesType
 */
class ArticleProductPrintSidesType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;
    
	/**
	 * @var ArticleProductPrintSideType 
	 * 
	 * Article product print side form type
	 */	
	protected $articleProductPrintSideType;
		
    /**
     * Construct
     *
	 * @param ArticleProductPrintSideType $articleProductPrintSideType ArticleProductPrintSides form type
     */
    public function __construct(
		ArticleProductPrintSideType $articleProductPrintSideType
	) {	
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
			->add('articleProductPrintSides', 'collection', [
				'entry_type' => $this->articleProductPrintSideType,
			])
			->addEventSubscriber($this->articleProductPrintSidesFormEventListener);		
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
        return 'elcodi_admin_article_form_type_article_product_print_sides';
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
