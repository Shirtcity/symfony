<?php

namespace Elcodi\Bundle\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\ProductBundle\Repository\PrintSideTypeRepository;
use Elcodi\Bundle\ProductBundle\Factory\PrintSideFactory;

/**
 * Class ProductPrintSidesFormEventListener.
 */
class ProductPrintSidesFormEventListener implements EventSubscriberInterface
{
	/**
     * @var PrintSideTypeRepository
     *
     * PrintSideType repository
     */
    private $printSideTypeRepository;
	
	/**
     * @var PrintSideFactory
     *
     * PrintSide factory
     */
    private $printSideFactory;
	
	/**
     * ProductPrintSidesFormEventListener constructor.
     *
     * @param PrintSideTypeRepository $printSideTypeRepository     PrintSideTypeRepository repository
	 * @param PrintSideFactory $printSideFactory		 PrintSideFactory factory
     */
    public function __construct(
        PrintSideTypeRepository		$printSideTypeRepository,
		PrintSideFactory		$printSideFactory
    ) {
        $this->printSideTypeRepository = $printSideTypeRepository;
		$this->printSideFactory = $printSideFactory;
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
		$this->setMissingPrintSideTypes($entity);
    }
	
	/**
	 * Set missing print sides for entity.
	 * 
	 * @param entity $entity
	 */
	private function setMissingPrintSideTypes($entity)
	{
		$sideTypes = $this
			->printSideTypeRepository
			->findAll();
		
		foreach($sideTypes as $type) {		
			
			$sideExists = $entity->getPrintSides()->exists(
				function($key, $entry) use ($type) {
				   return $type->getId() === $entry->getType()->getId();
				}
			);
			
			if($sideExists === false) {
				$side = $this->printSideFactory->create();
				
				$side->setType($type);
				$side->setProduct($entity);
				
				$entity->addPrintSide($side);
			}
		}
	}
}
