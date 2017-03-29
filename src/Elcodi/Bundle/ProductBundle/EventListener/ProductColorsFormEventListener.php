<?php

namespace Elcodi\Bundle\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\ProductBundle\Repository\ProductColorRepository;
use Elcodi\Bundle\ProductBundle\Factory\ProductColorsFactory;

/**
 * Class ProductColorsFormEventListener.
 */
class ProductColorsFormEventListener implements EventSubscriberInterface
{
	/**
     * @var ProductColorRepository
     *
     * PrintSideType repository
     */
    private $productColorRepository;
	
	/**
     * @var ProductColorsFactory
     *
     * ProductColors factory
     */
    private $productColorsFactory;
	
	/**
     * ProductColorsFormEventListener constructor.
     *
     * @param ProductColorRepository $productColorRepository     ProductColor repository
	 * @param ProductColorsFactory $productColorsFactory		 ProductColors factory
     */
    public function __construct(
        ProductColorRepository		$productColorRepository,
		ProductColorsFactory		$productColorsFactory
    ) {
        $this->productColorRepository = $productColorRepository;
		$this->productColorsFactory = $productColorsFactory;
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
        $entity = $event->getData();		
		$this->setMissingColors($entity);
    }
	
	/**
	 * Set missing colors for entity.
	 * 
	 * @param entity $entity
	 */
	private function setMissingColors($entity)
	{
		$colors = $this
			->productColorRepository
			->findAll();
		
		foreach($colors as $color) {		
			
			$colorExists = $entity->getColors()->exists(
				function($key, $entry) use ($color) {
				   return $color->getId() === $entry->getColor()->getId();
				}
			);
			
			if($colorExists === false) {
				$poductColors = $this->productColorsFactory->create();
				
				$poductColors->setColor($color);
				$poductColors->setProduct($entity);
				
				$entity->addColor($poductColors);
			}
		}
	}
}
