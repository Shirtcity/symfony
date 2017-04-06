<?php

namespace Elcodi\Admin\ProductBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

use Elcodi\Component\Core\Factory\Traits\FactoryTrait;
use Elcodi\Component\EntityTranslator\EventListener\Traits\EntityTranslatableFormTrait;

use Elcodi\Bundle\PriceBundle\EventListener\PriceFormEventListener;

use Elcodi\Form\Type\EntityColorType;

use Elcodi\Admin\ProductBundle\Form\Type\ProductColorsType;
use Elcodi\Admin\ProductBundle\Form\Type\ProductSizesType;

use Yokai\ManyToManyMatrixBundle\Form\Type\ManyToManyMatrixType;

/**
 * Class ProductType
 */
class ProductType extends AbstractType
{
    use EntityTranslatableFormTrait, FactoryTrait;

    /**
     * @var string
     *
     * Image namespace
     */
    protected $imageNamespace;
		
	/**
     * @var string
     *
     * Manufacturer namespace
     */
	protected $manufacturerNamespace;
		
	/**
     * @var string
     *
     * PriceFormEventListener
     */
	protected $priceFormEventListener;
	
	/**
     * @var string
     *
     * ProductColorsFormEventListener
     */
	protected $productColorsFormEventListener;
	
	/**
     * @var string
     *
     * ProductSizesFormEventListener
     */
	protected $productSizesFormEventListener;
	
	/**
     * @var string
     *
     * ProductPrintSidesFormEventListener
     */
	protected $productPrintSidesFormEventListener;

	/**
     * Construct
     * 
	 * @param string $imageNamespace							Image namespace 
	 * @param string $manufacturerNamespace						Manufacturer namespace
	 * @param string $priceFormEventListener					PriceFormEventListener
	 * @param string $productColorsFormEventListener			ProductColorsFormEventListener
	 * @param string $productSizesFormEventListener				ProductSizesFormEventListener
	 * @param string $productPrintSidesFormEventListener	    ProductPrintSidesFormEventListener
     */
    public function __construct(
        $imageNamespace,
		$manufacturerNamespace,
		$priceFormEventListener,
		$productColorsFormEventListener,
		$productSizesFormEventListener,
		$productPrintSidesFormEventListener
    ) {
        $this->imageNamespace = $imageNamespace;
		$this->manufacturerNamespace = $manufacturerNamespace;
		$this->priceFormEventListener = $priceFormEventListener;	
		$this->productColorsFormEventListener = $productColorsFormEventListener;
		$this->productSizesFormEventListener = $productSizesFormEventListener;
		$this->productPrintSidesFormEventListener = $productPrintSidesFormEventListener;
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
            ->add('name', 'text', [
                'required'    => true,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('slug', 'text', [
                'required' => true,
                'constraints' => [
                    new Constraints\Length(
                        [
                            'max' => 65,
                        ]
                    ),
                ],
            ])
            ->add('description', 'textarea', [
                'required' => true,
            ])			
            ->add('imagesSort', 'text', [
                'required' => false,
            ])			
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
            ->add('height', 'number', [
                'required' => false,
            ])
            ->add('width', 'number', [
                'required' => false,
            ])
            ->add('weight', 'number', [
                'required' => false,
            ])
            ->add('product_manufacturer', 'entity', [
                'class'    => $this->manufacturerNamespace,
                'required' => false,
                'multiple' => false,
            ])
            ->add('images', 'entity', [
                'class'    => $this->imageNamespace,
                'required' => false,
                'property' => 'id',
                'multiple' => true,
                'expanded' => true,
            ])
			->add('sizes', CollectionType::class, [
                'entry_type'    => ProductSizesType::class,
				'allow_add'     => true,
                'allow_delete'  => true,
            ])
			->add('colors', CollectionType::class, [
                'entry_type'    => ProductColorsType::class,
				'allow_add'     => true,
                'allow_delete'  => true,
            ])
			->add('printSides', CollectionType::class, [
                'entry_type'    => ProductPrintSidesType::class,
				'allow_add'     => true,
                'allow_delete'  => true,
            ])
			/*
			->add('sizes', 'Yokai\ManyToManyMatrixBundle\Form\Type\ManyToManyMatrixType', [
                'class'    => \Elcodi\Bundle\ProductBundle\Entity\ProductSizes::class,
                'required' => false,
				'association' => 'colors',
            ])
			 * 
			 */
			;
		
		$builder->addEventSubscriber($this->priceFormEventListener);
		$builder->addEventSubscriber($this->productColorsFormEventListener);
		$builder->addEventSubscriber($this->productSizesFormEventListener);
		$builder->addEventSubscriber($this->productPrintSidesFormEventListener);
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
        return 'elcodi_admin_product_form_type_product';
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
