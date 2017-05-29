<?php

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Machine;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\Order;

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
        $machineManager = $this->getMachineManager(
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
        $machineManager = $this->getMachineManager(null, $blockStates);
        
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
        $machineManager = $this->getMachineManager(
            'getWorkflowStateLineStack', 
            $blockStates
        );
        
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
        
        $this->setWorkflowState($order, $workflowStateName);
        
        $stateLineStack = $machineManager->transition(
            $order,
            $stateLineStack,
            'pay',
            ''
        );
        
        $lastStateName = $stateLineStack
            ->getLastStateLine()
            ->getState()
            ->getName();
        
        $this->assertEquals($expectedStateName, $lastStateName);
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
        $machineManager = $this->getMachineManager(
            'getWorkflowStateLineStack', 
            $blockStates
        );
        
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
        
        $this->setWorkflowState($order, $workflowStateName);
                
        $availableStates = $machineManager->getAvailableStates($order, 'unpaid');   
        $availableStateNames = [];
        
        foreach ($availableStates as $state) {
            $availableStateNames[] = $state->getName();
        }
        
        $this->assertEquals($expectedAvailableStateNames, $availableStateNames);
    }
}
