<?php

namespace Elcodi\Component\Article\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Component\Article\Services\ArticleProductColorResolver;
use Elcodi\Component\Article\Services\ArticleProductPrintSidesManager;

/**
 * Class ArticleProductPrintSideFormEventListener.
 */
class ArticleProductFormEventListener implements EventSubscriberInterface
{
	/**
	 * @var ArticleProductColorResolver 
	 * 
	 * ArticleProduct Color Resolver
	 */
	protected $articleProductColorResolver;
	
	/**
	 * @var ArticleProductPrintSidesManager
	 * 
	 * ArticleProduct Print Sides Manager 
	 */
	protected $articleProductPrintSidesManager;

	/**
     * Constructor
     *
	 * @param ArticleProductColorResolver $articleProductColorResolver ArticleProduct Color Resolver
	 * @param ArticleProductPrintSidesManager $articleProductPrintSidesManager ArticleProduct Print Sides Manager
     */
    public function __construct(
		ArticleProductColorResolver	$articleProductColorResolver,
		ArticleProductPrintSidesManager	$articleProductPrintSidesManager
    ) {
		$this->articleProductColorResolver = $articleProductColorResolver;
		$this->articleProductPrintSidesManager = $articleProductPrintSidesManager;
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
            FormEvents::PRE_SET_DATA	=> 'preSetData',
			FormEvents::SUBMIT			=> 'submit',
			FormEvents::POST_SUBMIT		=> 'postSubmit',
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
	
		$this->updateProductColor($articleProduct);
		$this->preSetArticleProductPrintSides($articleProduct);
    }
	
	/**
     * Pre Submit
     *
     * @param FormEvent $event Event
     */
    public function submit(FormEvent $event)
    {
		$articleProduct = $event->getData();
				
		$this->preSetArticleProductPrintSides($articleProduct);
    }
	
	/**
     * Post Submit
     *
     * @param FormEvent $event Event
     */
    public function postSubmit(FormEvent $event)
    {
		$articleProduct = $event->getData();
		
		$this->updateProductColor($articleProduct);		
		$this->preSetArticleProductPrintSides($articleProduct);
    }

	/**
     * Update article product colors for new selected product
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     */
	private function updateProductColor(ArticleProductInterface $articleProduct)
	{
		$this
			->articleProductColorResolver
			->resolveArticleProductColor($articleProduct);
	}
	
	/**
     * Update article product print sides
	 * 
	 * Generates default print sides and new print side for each not available for selected product print side types
	 * Existing printable variants will be copied to corresponding product print sides
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     */
	private function preSetArticleProductPrintSides(ArticleProductInterface $articleProduct)
	{           
		$this
			->articleProductPrintSidesManager
            ->generateDefaultPrintSides($articleProduct)
			->preSetArticleProductPrintSides($articleProduct);
	}
}
