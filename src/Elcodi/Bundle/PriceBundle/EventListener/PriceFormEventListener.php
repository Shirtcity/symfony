<?php

namespace Elcodi\Bundle\PriceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Repository\CurrencyRepository;

/**
 * Class PriceFormEventListener.
 */
class PriceFormEventListener implements EventSubscriberInterface
{
	/**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;
	
	/**
     * PriceFormEventListener constructor.
     *
     * @param CurrencyRepository $currencyRepository     Currency repository
     */
    public function __construct(
        CurrencyRepository $currencyRepository
    ) {
        $this->currencyRepository = $currencyRepository;
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
        $form = $event->getForm();
		
		$this->setMissingPrices($entity);
		
		$form->add('prices', CollectionType::class, [
			'entry_type' => 'money_object',				
			'required' => true,		
		]);
    }
	
	/**
	 * Set missing prices for entity.
	 * 
	 * @param entity $entity
	 */
	private function setMissingPrices($entity)
	{
		$currencies = $this
			->currencyRepository
			->findByEnabled(true);
		
		foreach($currencies as $currency) {			
			
			$priceExists = $entity->getPrices()->exists(
				function($key, $entry) use ($currency) {
				   return $currency->getIso() === $entry->getCurrency()->getIso();
				}
			); 
			
			if($priceExists === false) {
				$entity->setPrice(
					Money::create(0, $currency)
				);
			}
		}
	}
}
