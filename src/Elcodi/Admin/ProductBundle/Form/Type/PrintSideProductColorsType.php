<?php

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class PrintSideProductColorsType
 */
class PrintSideProductColorsType extends AbstractType
{
    use FactoryTrait;    
	
	/**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;

    /**
     * PrintSideProductColorsType constructor.
     *
	 * @param string $imageNamespace				Image namespace 
     */
    public function __construct(
		$imageNamespace
	)
    {
		$this->imageNamespace = $imageNamespace;
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
			->add('image', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'multiple' => false,
                'property' => 'id',
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
        return 'elcodi_admin_product_form_type_print_side_product_colors';
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
