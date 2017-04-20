<?php

namespace Elcodi\Component\Article\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\PrintableBundle\Factory\TextVariantFactory;
use Elcodi\Bundle\PrintableBundle\Factory\DesignVariantFactory;

/**
 * Class ArticleProductPrintSideFormEventListener.
 */
class ArticleProductPrintSideFormEventListener implements EventSubscriberInterface
{
	/**
	 * @var TextVariantFactory
	 * 
	 * Text variant factory
	 */	
	protected $textVariantFactory;	
	
	/**
	 * @var DesignVariantFactory 
	 * 
	 * Design variant factory
	 */	
	protected $designVariantFactory;	
	
	/**
     * Constructor
     *
     * @param TextVariantFactory $textVariantFactory text variant factory
	 * @param DesignVariantFactory $designVariantFactory design variant factory
     */
    public function __construct(
        TextVariantFactory $textVariantFactory,
		DesignVariantFactory $designVariantFactory
    ) {
        $this->textVariantFactory = $textVariantFactory;
		$this->designVariantFactory = $designVariantFactory;
	}
	
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    /**
     * Pre set data.
     *
     * @param FormEvent $event Event
     */
    public function preSetData(FormEvent $event)
    {
		$printableVariants = $event->getData()->getPrintableVariants();				

		if($event->getData()->getPrintableVariants()->isEmpty()) {

			$printableVariants->add(
				$this->textVariantFactory->create()
			);

			$printableVariants->add(
				$this->designVariantFactory->create()
			);
		}
    }	
}
