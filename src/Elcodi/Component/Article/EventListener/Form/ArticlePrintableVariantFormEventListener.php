<?php

namespace Elcodi\Component\Article\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;
use Elcodi\Component\Article\Adapter\ArticlePrintableVariantSizeAdapter;

/**
 * Class ArticlePrintableVariantFormEventListener.
 */
class ArticlePrintableVariantFormEventListener implements EventSubscriberInterface
{
	/**
	 * @var ArticlePrintableVariantSizeAdapter 
	 * 
	 * Article PrintableVariant size adapter 
	 */
	protected $articlePrintableVariantSizeAdapter;

	/**
     * Constructor
     *
	 * @param ArticlePrintableVariantSizeAdapter $articlePrintableVariantSizeAdapter Article PrintableVariant size adapter
     */
    public function __construct(
		ArticlePrintableVariantSizeAdapter $articlePrintableVariantSizeAdapter
    ) {
		$this->articlePrintableVariantSizeAdapter = $articlePrintableVariantSizeAdapter;
	}
	
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
			FormEvents::POST_SUBMIT	=> 'postSubmit',
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
		
        $this->scalePrintableHeight($printableVariant);
    }

	/**
     * Scale printable variant height according to printable variant width
     *
     * @param PrintableVariantInterface $printableVariant
     */
	private function scalePrintableHeight(PrintableVariantInterface $printableVariant)
	{
		$this
			->articlePrintableVariantSizeAdapter
            ->setPrintableVariant($printableVariant)
			->scalePrintableHeight();
	}	
	
}
