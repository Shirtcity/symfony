<?php

namespace Elcodi\Component\Article\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Component\Article\Factory\ArticleProductPrintSideFactory;

/**
 * Class ArticleProductPrintSidesFormEventListener.
 */
class ArticleProductPrintSidesFormEventListener implements EventSubscriberInterface
{
	/**
	 * @var ArticleProductPrintSide 
	 * 
	 * Article product print side factory
	 */	
	protected $articleProductPrintSideFactory;	
	
	/**
     * PrintSideFormEventListener constructor.
     *
     * @param ArticleProductPrintSideFactory $articleProductPrintSideFactory ArticleProductPrintSide factory
     */
    public function __construct(
        ArticleProductPrintSideFactory $articleProductPrintSideFactory
    ) {
        $this->articleProductPrintSideFactory = $articleProductPrintSideFactory;
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
		$articleProduct = $event->getData();
		$productPrintSides = $event->getData()->getProduct()->getPrintSides();

		if($articleProduct->getArticleProductPrintSides()->isEmpty()) {

			$productPrintSides->map(function($printSide) use ($articleProduct){
				$articleProductPrintSide = $this->articleProductPrintSideFactory->create();
				$articleProductPrintSide
					->setPrintSide($printSide)
					->setArticleProduct($articleProduct);
				$articleProduct->addArticleProductPrintSide($articleProductPrintSide);
			});							
		}
    }	
}
