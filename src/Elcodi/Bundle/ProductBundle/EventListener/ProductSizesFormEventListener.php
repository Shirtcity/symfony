<?php

namespace Elcodi\Bundle\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Elcodi\Bundle\ProductBundle\Repository\ProductSizeRepository;
use Elcodi\Bundle\ProductBundle\Factory\ProductSizesFactory;

/**
 * Class ProductSizesFormEventListener.
 */
class ProductSizesFormEventListener implements EventSubscriberInterface
{
	/**
     * @var ProductSizeRepository
     *
     * PrintSideType repository
     */
    private $productSizeRepository;
	
	/**
     * @var ProductSizesFactory
     *
     * ProductSizes factory
     */
    private $productSizesFactory;
	
	/**
     * ProductSizesFormEventListener constructor.
     *
     * @param ProductSizeRepository $productSizeRepository     ProductSize repository
	 * @param ProductSizesFactory $productSizesFactory		 ProductSizes factory
     */
    public function __construct(
        ProductSizeRepository		$productSizeRepository,
		ProductSizesFactory			$productSizesFactory
    ) {
        $this->productSizeRepository = $productSizeRepository;
		$this->productSizesFactory = $productSizesFactory;
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
		$this->setMissingSizes($entity);
    }
	
	/**
	 * Set missing sizes for entity.
	 * 
	 * @param entity $entity
	 */
	private function setMissingSizes($entity)
	{
		$sizes = $this
			->productSizeRepository
			->findAll();
		
		foreach($sizes as $size) {	
			$sizeExists = $entity->getSizes()->exists(
				function($key, $entry) use ($size) {
				   return $size->getId() === $entry->getSize()->getId();
				}
			);
			
			if($sizeExists === false) {
				$poductSizes = $this->productSizesFactory->create();
				
				$poductSizes->setSize($size);
				$poductSizes->setProduct($entity);
				
				$entity->addSize($poductSizes);
			}
		}
	}
}
