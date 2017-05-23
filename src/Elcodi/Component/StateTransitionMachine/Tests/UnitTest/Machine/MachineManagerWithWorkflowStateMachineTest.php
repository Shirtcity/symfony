<?php

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Machine;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\StateTransitionMachine\Entity\StateLine;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\Order;

use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class MachineManagerWithWorkflowStateMachineTest.
 */
class MachineManagerWithWorkflowStateMachineTest extends AbstractStateTransitionTest
{
    /**
     * data for dataBlockStates
     */
    public function dataBlockStates()
    {
        return [
            [
                [
                    'paused',
                    'cancelled',
                ]
            ]
        ];
    }
    
    /**
     * Test transition with invalid getter.
     *
     * @param array $blockStates block states
     *
     * @dataProvider dataBlockStates
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\InvalidWorkflowLineStackGetterException
     */
    public function testInvalidWorkflowStateLineStackGetterName($blockStates)
    {
        $machine = $this->getMachine();
        $stateLineFactory = $this->getStateLineFactory();
        $eventDispatcher = $this->getMachineEventDispatcher();
		
        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory,
            'getInvalidWorkflowStateLineStackGetterName',
            $blockStates
        );
        
        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );
    }
    
    /**
     * Test transition with missing getter and block states.
     * 
     * @param array $blockStates block states
     *
     * @dataProvider dataBlockStates
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\MissingWorkflowLineStackGetterNameException
     */
    public function testMissingWorkflowStateLineStackGetterName($blockStates)
    {
        $machine = $this->getMachine();
        $stateLineFactory = $this->getStateLineFactory();
        $eventDispatcher = $this->getMachineEventDispatcher();
		
        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory,
            null,
            $blockStates
        );
        
        $order = new Order();
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        $order->setStateLineStack($stateLineStack);

        $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );
    }
    
    /**
     * Data for testBlockingByWorkflowState.
     */
    public function dataBlockingByWorkflowState()
    {
        return [
            'blocked' => [['paused'], 'paused', 'unpaid'],
            'not blocked' => [['paused'], 'processing', 'paid'],
            'without blocking states' => [null, 'paused', 'paid'],
        ];
    }
    
    /**
     * Test blocking by workflow state machine.
     * 
     * @param array     $blockStates block states
     * @param string    $workflowStateName workflow state
     * @param string    $expectedStateName state name of curren StateMachine after transition
     *
     * @dataProvider dataBlockingByWorkflowState
     */
    public function testBlockingByWorkflowState(
        $blockStates,
        $workflowStateName,
        $expectedStateName
    ) {
        /**
         * Create MachineManager
         */
        $machine = $this->getMachine();
        $stateLineFactory = $this->getStateLineFactory();
        $eventDispatcher = $this->getMachineEventDispatcher();
		
        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory,
            'getWorkflowStateLineStack',
            $blockStates
        );
        
        /**
         * Set StateLineStack for current StateMachine
         */
        $order = new Order();
        
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        
        $stateLineStack = $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );
        $order->setStateLineStack($stateLineStack);
        
        
        /**
         * Set StateLineStack for Workflow StateMachine
         */
        
        $workflowState = $this->getState($workflowStateName);
        $workflowStateLine = $stateLineFactory
            ->create()
            ->setState($workflowState);
        
        $workflowStateLines = new ArrayCollection();
        $workflowStateLines[] = $workflowStateLine;
        
        $workflowStateLineStack = StateLineStack::create(
            $workflowStateLines,
            $workflowStateLine
        );
        $order->setWorkflowStateLineStack($workflowStateLineStack);
        
        
        $stateLineStack = $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );
        
        $lastState = $stateLineStack
            ->getLastStateLine()
            ->getState()
            ->getName();
        
        $this->assertEquals($expectedStateName, $lastState);
    }
    
    /**
     * Data for testAvailableStatesWithBlockingByWorkflowState.
     */
    public function dataAvailableStatesWithBlockingByWorkflowState()
    {
        return [
            'blocked' => [['paused'], 'paused', []],
            'not blocked' => [['paused'], 'processing', ['pay', 'revise']],
        ];
    }
    
    /**
     * Test available states
     * 
     * @param array     $blockStates block states
     * @param string    $workflowStateName workflow state
     * @param array     $expectedAvailableStateNames array of available state names
     *
     * @dataProvider dataAvailableStatesWithBlockingByWorkflowState
     */
    public function testAvailableStatesWithBlockingByWorkflowState(
        $blockStates,
        $workflowStateName,
        $expectedAvailableStateNames
    ) {
        /**
         * Create MachineManager
         */
        $machine = $this->getMachine();
        $stateLineFactory = $this->getStateLineFactory();
        $eventDispatcher = $this->getMachineEventDispatcher();
		
        $machineManager = new MachineManager(
            $machine,
            $eventDispatcher,
            $stateLineFactory,
            'getWorkflowStateLineStack',
            $blockStates
        );
        
        /**
         * Set StateLineStack for current StateMachine
         */
        $order = new Order();
        
        $stateLineStack = StateLineStack::create(
            new ArrayCollection(),
            null
        );
        
        $stateLineStack = $machineManager->initialize(
            $order,
            $stateLineStack,
            ''
        );
        $order->setStateLineStack($stateLineStack);
        
        
        /**
         * Set StateLineStack for Workflow StateMachine
         */
        
        $workflowState = $this->getState($workflowStateName);
        $workflowStateLine = $stateLineFactory
            ->create()
            ->setState($workflowState);
        
        $workflowStateLines = new ArrayCollection();
        $workflowStateLines[] = $workflowStateLine;
        
        $workflowStateLineStack = StateLineStack::create(
            $workflowStateLines,
            $workflowStateLine
        );
        $order->setWorkflowStateLineStack($workflowStateLineStack);
                
        $availableStates = $machineManager->getAvailableStates($order, 'unpaid');   
        $availableStateNames = [];
        
        foreach ($availableStates as $state) {
            $availableStateNames[] = $state->getName();
        }
        
        $this->assertEquals($expectedAvailableStateNames, $availableStateNames);
    }
}
