<?php

namespace Elcodi\Component\Article\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Component\Article\Adapter\PrintableHeightAdapter;

/**
 * Class ArticleProductPrintSideFormEventListener.
 */
class PrintableVariantFormEventListener implements EventSubscriberInterface
{
	/**
	 * @var PrintableHeightAdapter 
	 * 
	 * PrintableVariant height adapter 
	 */
	protected $printableHeightAdapter;

	/**
     * Constructor
     *
	 * @param PrintableHeightAdapter $printableVariantHeightAdapter PrintableVariant height adapter
     */
    public function __construct(
		PrintableHeightAdapter $printableHeightAdapter
    ) {
		$this->printableHeightAdapter = $printableHeightAdapter;
	}
	
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
			FormEvents::POST_SUBMIT		=> 'postSubmit',
        ];
    }    
	
	/**
     * Post Submit
     *
     * @param FormEvent $event Event
     */
    public function postSubmit(FormEvent $event)
    {
		$printableVariant = $event->getData();
		
        if ((int)$printableVariant->getHeight() == 0) {
            $this->adaptPrintableHeight($printableVariant);
        }
    }

	/**
     * Adapt printable variant height according to printable variant width
     *
     * @param PrintableVariantInterface $printableVariant
     */
	private function adaptPrintableHeight(PrintableVariantInterface $printableVariant)
	{
		$this
			->printableHeightAdapter
			->adaptPrintableHeight($printableVariant);
	}	
	
}
