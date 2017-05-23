<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures;

use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Core\Factory\DateTimeFactory;
use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Definition\TransitionChain;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;
use Elcodi\Component\StateTransitionMachine\Machine\Machine;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;
use Elcodi\Component\StateTransitionMachine\Factory\StateFactory;

/**
 * Class MachineMockery.
 */
abstract class AbstractStateTransitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Return compiled machine.
     *
     * @return Machine Machine instance
     */
    public function getMachine()
    {        
        $transitionChain = TransitionChain::create();
        $transitionChain
            ->addTransition(new Transition('pay', $this->getState('unpaid'), $this->getState('paid')))
            ->addTransition(new Transition('revise', $this->getState('unpaid'), $this->getState('revised')))
            ->addTransition(new Transition('ship', $this->getState('revised'), $this->getState('shipped')));

        $machine = new Machine(
            'id',
            $transitionChain,
            $this->getState('unpaid')
        );

        return $machine;
    }

    /**
     * Return transition.
     *
     * @return Transition transition
     */
    public function getTransition()
    {
        $transition = new Transition(
            'pay',
            $this->getState('unpaid'),
            $this->getState('paid')
        );

        return $transition;
    }
    
    /**
     * Return State
     * 
     * @param string $name
     * @return State
     */
    protected function getState($name)
    {
        $stateFactory = new StateFactory;        
        $stateFactory->setEntityNamespace('Elcodi\Component\StateTransitionMachine\Entity\State');
        
        $state = $stateFactory->create();
        $state->setName($name);
        
        return $state;
    }
    
    /**
     * Return StateRepository
     * 
     * @return StateRepository
     */
    protected function getStateRepository()
    {
        $stateRepository = $this
            ->getMockBuilder('Elcodi\Component\StateTransitionMachine\Repository\StateRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        $stateRepository
            ->method('findOneBy')
            ->will($this->returnCallback([$this, 'mockState']));
        
        return $stateRepository;
    }
    
    /**
     * Callback function for function getStateRepository.
     * Return State.
     *  
     * @return State
     */
    public function mockState()
    {
        $args = func_get_args();        
        $stateName = $args[0]['name'];
        
        return $this->getState($stateName);
    }

    /**
     * Return MachineManager.
     *
     * @return MachineManager Machine Manager
     */
    public function getMachineManager()
    {
        $machine = $this->getMachine();
        $stateLineFactory = $this->getStateLineFactory();
        $eventDispatcher = $this->getMachineEventDispatcher();
		
        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory
        );

        return $machineManager;
    }
    
    /**
     * Retrun StateLineFactory
     * 
     * @return StateLineFactory
     */
    protected function getStateLineFactory()
    {
        $stateLineFactory = new StateLineFactory();
        $stateLineFactory->setEntityNamespace('Elcodi\Component\StateTransitionMachine\Entity\StateLine');
        $stateLineFactory->setDateTimeFactory(new DateTimeFactory());
        
        return $stateLineFactory;
    }
    
    /**
     * Return Mock of MachineEventDispatcher
     * 
     * @return MachineEventDispatcher
     */
    protected function getMachineEventDispatcher()
    {
        return $this
			->getMockBuilder('Elcodi\Component\StateTransitionMachine\EventDispatcher\MachineEventDispatcher')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
    }
}
