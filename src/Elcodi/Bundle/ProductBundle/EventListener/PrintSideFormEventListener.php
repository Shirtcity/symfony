<?php

namespace Elcodi\Bundle\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\ProductBundle\Factory\PrintSideAreaFactory;
use Elcodi\Bundle\ProductBundle\Factory\PrintSideProductColorsFactory;
use Elcodi\Bundle\ProductBundle\Repository\ProductColorsRepository;

/**
 * Class PrintSideFormEventListener.
 */
class PrintSideFormEventListener implements EventSubscriberInterface
{
	/**
     * @var PrintSideAreaFactory
     *
     * PrintSideArea factory
     */
    private $printSideAreaFactory;
	
	/**
     * @var PrintSideProductColorsFactory
     *
     * PrintSideProductColors factory
     */
    private $printSideProductColorsFactory;
	
	/**
     * @var ProductColorsRepository
     *
     * ProductColors repository
     */
    private $productColorsRepository;
	
	
	
	/**
     * PrintSideFormEventListener constructor.
     *
     * @param PrintSideAreaFactory $printSideAreaFactory					   PrintSideArea factory
	 * @param PrintSideProductColorsFactory $printSideProductColorsFactory     PrintSideProductColors factory
	 * @param ProductColorsRepository $productColorsRepository				   ProductColors repository
     */
    public function __construct(
        PrintSideAreaFactory $printSideAreaFactory,
		PrintSideProductColorsFactory $printSideProductColorsFactory,
		ProductColorsRepository $productColorsRepository
    ) {
        $this->printSideAreaFactory = $printSideAreaFactory;
		$this->printSideProductColorsFactory = $printSideProductColorsFactory;
		$this->productColorsRepository = $productColorsRepository;
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
        
		if($entity->hasAreas() === false) {
			$area = $this
				->printSideAreaFactory
				->create();
			
			$area->setSide($entity);
			$entity->addArea($area);
		}
		
		$this->setMissingPrintSideProductColors($entity);
    }
	
	/**
	 * Set missing colors for entity.
	 * 
	 * @param entity $entity
	 */
	private function setMissingPrintSideProductColors($entity)
	{
		$productId = $entity
						->getProduct()
						->getId();
		
		$productColors = $this
                            ->productColorsRepository
                            ->findByProduct($productId);
		
		foreach($productColors as $productColor) {		
			
			$productColorExists = $entity->getSideProductColors()->exists(
				function($key, $entry) use ($productColor) {
				   return $productColor->getId() === $entry->getProductColors()->getId();
				}
			);
			
			if($productColorExists === false) {
                
				$sideProductColor = $this
										->printSideProductColorsFactory
										->create();
				
				$sideProductColor->setProductColors($productColor);
				$sideProductColor->setSide($entity);
				
				$entity->addSideProductColor($sideProductColor);
			}
		}
	}
}
