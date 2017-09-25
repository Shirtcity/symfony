<?php

namespace Elcodi\Store\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;


use Elcodi\Store\ArticleBundle\Form\Type\ArticleSimpleProductType;
use Elcodi\Bundle\ProductBundle\Entity\Product;


/**
 * Class ArticleSimpleType
 */
class ArticleSimpleType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

	/**
	 * @var $articleProductSimpleType 
	 * 
	 * ArticleSimpleProductType FormType
	 */
	protected $articleProductSimpleType;
	

    /**
     * Construct
     *
	 * @param ArticleSimpleProductType $articleProductSimpleType	Article simple product form type
     */
    public function __construct(
		ArticleSimpleProductType $articleProductSimpleType
    ) {
		$this->articleProductSimpleType = $articleProductSimpleType;
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
            ->add('articleProduct', $this->articleProductSimpleType)
            ->add('quantity', 'integer', [
                'mapped' => false,
            ]);            
        
        $builder
            ->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event) use ($options) {
                    $entity = $event->getData();
                    $form = $event->getForm();
					
                    $sizes = $entity
                        ->getArticleProduct()
                        ->getProduct()
                        ->getSizes();
                    
					$form
						->add('size', 'entity', [
                            'class'     => \Elcodi\Bundle\ProductBundle\Entity\ProductSizes::class,
                            'mapped'    => false,
                            'multiple'  => false,
                            'expanded'  => false,
                            'property'  => 'size.name',
                            'choices'   => $sizes,
                        ]);
                }
            )
        ;
            
        $builder->add('addToCart', 'submit', array(
            'attr' => array('class' => 'add-to-cart'),
        ));

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
        return 'elcodi_store_article_simple_form_type_article';
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
