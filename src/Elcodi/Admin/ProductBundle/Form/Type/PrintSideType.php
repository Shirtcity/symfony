<?php

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class PrintSideType
 */
class PrintSideType extends AbstractType
{
    use FactoryTrait;    
	
	/**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;
	
	/**
     * PrintSideFormEventListener
     */
    protected $printSideFormEventListener;

    /**
     * PrintSidesType constructor.
     *
	 * @param string $imageNamespace				Image namespace 
     * @param string $printSideFormEventListener	PrintSideFormEventListener
     */
    public function __construct(
		$imageNamespace,
		$printSideFormEventListener
	)
    {
		$this->imageNamespace = $imageNamespace;
        $this->printSideFormEventListener = $printSideFormEventListener;
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
            ->add('enabled', CheckboxType::class, [
				'required' => false,
			])
			->add('areas', CollectionType::class, [
                'entry_type'    => PrintSideAreaType::class,
				'allow_add'     => true,
                'allow_delete'  => true,
				'by_reference'	=> false,
            ])
			->add('sideProductColors', CollectionType::class, [
                'entry_type'    => PrintSideProductColorsType::class,
				'allow_add'     => true,
                'allow_delete'  => true,
				'by_reference'	=> false,
            ])
			->add('image', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
            ]);
		
		$builder->addEventSubscriber($this->printSideFormEventListener);
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
        return 'elcodi_admin_product_form_type_print_side';
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
