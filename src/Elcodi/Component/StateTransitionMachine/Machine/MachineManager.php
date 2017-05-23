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

namespace Elcodi\Component\StateTransitionMachine\Machine;

use Elcodi\Component\StateTransitionMachine\Definition\Transition;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\EventDispatcher\MachineEventDispatcher;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectAlreadyInitializedException;
use Elcodi\Component\StateTransitionMachine\Exception\ObjectNotInitializedException;
use Elcodi\Component\StateTransitionMachine\Exception\StateNotReachableException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotAccessibleException;
use Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException;
use Elcodi\Component\StateTransitionMachine\Exception\InvalidWorkflowLineStackGetterException;
use Elcodi\Component\StateTransitionMachine\Exception\MissingWorkflowLineStackGetterNameException;
use Elcodi\Component\StateTransitionMachine\Factory\StateLineFactory;
use Elcodi\Component\StateTransitionMachine\Machine\Interfaces\MachineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateInterface;

/**
 * Class MachineManager.
 */
class MachineManager
{
    /**
     * @var MachineInterface
     *
     * Machine
     */
    private $machine;

    /**
     * @var MachineEventDispatcher
     *
     * Machine Event Dispatcher
     */
    private $machineEventDispatcher;

    /**
     * @var StateLineFactory
     *
     * StateLine factory
     */
    private $stateLineFactory;
    
    /**
     * @var string
     *
     * Workflow State Line Stack Getter Name
     */
    private $workflowStateLineStackGetterName;
    
    /**
     * @var array
     *
     * Workflow Block States
     */
    private $workflowBlockStates;

    /**
     * Construct.
     *
     * @param MachineInterface       $machine                               Machine
     * @param MachineEventDispatcher $machineEventDispatcher                Event Dispatcher
     * @param StateLineFactory       $stateLineFactory                      StateLine Factory
     * @param string                 $workflowStateLineStackGetterName      Workflow State Line Stack Getter Name
     * @param array                  $workflowBlockStates                   Workflow Block States
     */
    public function __construct(
        MachineInterface $machine,
        MachineEventDispatcher $machineEventDispatcher,
        StateLineFactory $stateLineFactory,
        $workflowStateLineStackGetterName = false,
        $workflowBlockStates = false
    ) {
        $this->machine = $machine;
        $this->machineEventDispatcher = $machineEventDispatcher;
        $this->stateLineFactory = $stateLineFactory;
        $this->workflowStateLineStackGetterName = $workflowStateLineStackGetterName;
        $this->workflowBlockStates = $workflowBlockStates;
    }

    /**
     * Initialize the object into the machine.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws ObjectAlreadyInitializedException Object already initialized
     */
    public function initialize(
        $object,
        StateLineStack $stateLineStack,
        $description
    ) {        
        if ($stateLineStack->getLastStateLine() instanceof StateLineInterface) {
            throw new ObjectAlreadyInitializedException();
        }

        $entryState = $this
            ->machine
            ->getEntryState();

        $stateLine = $this->createStateLine(
            $entryState,
            $description
        );

        $stateLineStack->addStateLine($stateLine);

        $this
            ->machineEventDispatcher
            ->dispatchInitializationEvents(
                $this->machine,
                $object,
                $stateLineStack
            );
        
        return $stateLineStack;
    }

    /**
     * Applies a transition given a object.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $transitionName Transition name
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws TransitionNotAccessibleException Transition not accessible
     * @throws TransitionNotValidException      Invalid transition
     * @throws ObjectNotInitializedException    Object needs to be initialized in machine
     */
    public function transition(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description = ''
    ) {
        return $this
            ->applyTransitionAction(
                $object,
                $stateLineStack,
                $transitionName,
                $description,
                'transition'
            );
    }

    /**
     * Applies a transition given a object.
     *
     * @param mixed          $object         Object
     * @param StateLineStack $stateLineStack StateLine Stack
     * @param string         $transitionName Transition name
     * @param string         $description    Description
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws StateNotReachableException    State is not reachable
     * @throws ObjectNotInitializedException Object needs to be initialized in machine
     */
    public function reachState(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description = ''
    ) {
        return $this
            ->applyTransitionAction(
                $object,
                $stateLineStack,
                $transitionName,
                $description,
                'reachState'
            );
    }

    /**
     * Create an state line given its name and description.
     *
     * @param State  $state        State
     * @param string $description Description
     *
     * @return StateLineInterface State Line
     */
    public function createStateLine(StateInterface $state, $description)
    {
        $stateLine = $this
            ->stateLineFactory
            ->create()
            ->setState($state)
            ->setDescription($description);

        return $stateLine;
    }

    /**
     * Applies a transition action given a object and the kind of transition is
     * needed.
     *
     * @param mixed          $object           Object
     * @param StateLineStack $stateLineStack   StateLine Stack
     * @param string         $transitionName   Transition name
     * @param string         $description      Description
     * @param string         $transitionAction Transition Action
     *
     * @return StateLineStack StateLine stack given
     *
     * @throws StateNotReachableException    State is not reachable
     * @throws ObjectNotInitializedException Object needs to be initialized in machine
     */
    private function applyTransitionAction(
        $object,
        StateLineStack $stateLineStack,
        $transitionName,
        $description,
        $transitionAction
    ) {        
        if (!$this->isBlockedByWorkflowStateMachine($object)) {
        
            $startState = $stateLineStack->getLastStateLine();

            if (!($startState instanceof StateLineInterface)) {
                throw new ObjectNotInitializedException();
            }

            /**
             * @var Transition $transition
             */
            $transition = $this
                ->machine
                ->$transitionAction(
                    $startState
                        ->getState()
                        ->getName(),
                    $transitionName
                );
            
            $stateLine = $this->createStateLine(
                $transition->getFinal(),
                $description
            );
            
            $stateLineStack->addStateLine($stateLine);

            $this
                ->machineEventDispatcher
                ->dispatchTransitionEvents(
                    $this->machine,
                    $object,
                    $stateLineStack,
                    $transition
                );
        }
        
        return $stateLineStack;
    }
    
    /**
     * Get available states given a start state.
     *
     * @param mixed  $object            Object
     * @param string $startStateName    Start state name
     *
     * @return array Set of states
     */
    public function getAvailableStates($object, $startStateName)
    {        
        return !$this->isBlockedByWorkflowStateMachine($object)
                    ? $this->machine->getAvailableStates($startStateName)
                    : [];
    }
    
    /**
     * Check if current States Machine is blocked by Workflow States Machine if it has blocking.
     * 
     * @param mixed $object  Object
     * 
     * @return bool
     */
    private function isBlockedByWorkflowStateMachine($object)
    {       
        return $this->hasBlockingByWorkflowStateMachine()
                ? $this->checkBlockingByWorkflowStateMachine($object) 
                : false;
    }
    
    /**
     * Check if current States Machine has blocking by Workflow States Machine in configuration
     * 
     * @return bool
     */
    private function hasBlockingByWorkflowStateMachine()
    {
        $this->checkBlockingByWorkflowStateMachineConfiguration();
        
        return $this->workflowBlockStates && $this->workflowStateLineStackGetterName
                ? true
                : false;
    }
    
    /**
     * Check blocking configuration of State Machine
     * 
     * @throws MissingWorkflowLineStackGetterNameException
     */
    private function checkBlockingByWorkflowStateMachineConfiguration()
    {
        if ($this->workflowBlockStates && !$this->workflowStateLineStackGetterName) {
            throw new MissingWorkflowLineStackGetterNameException();
        }
    }
    
    /**
     * Check if current States Machine is blocked by Workflow States Machine
     * 
     * @param mixed $object  Object
     * 
     * @return bool
     */
    private function checkBlockingByWorkflowStateMachine($object)
    {
        $workflowLastStateName = $this->getWorkflowLastStateName($object);
        
        return in_array($workflowLastStateName, $this->workflowBlockStates) 
                ? true 
                : false;
    }
    
    /**
     * Return workflow last state name
     * 
     * @param mixed $object  Object
     * 
     * @return string
     */
    private function getWorkflowLastStateName($object)
    {
        $workflowStateLineStack = $this->getWorkflowStateLineStack($object);
        
        return $workflowStateLineStack
            ->getLastStateLine()
            ->getState()
            ->getName();
    }
    
    /**
     * Return workflow state line stack
     * 
     * @param mixed $object  Object
     * 
     * @return StateLineStack
     */
    private function getWorkflowStateLineStack($object)
    {
        $workflowStateLineStackGetterName = $this->workflowStateLineStackGetterName;
        
        $this->checkWorkflowStateLineStackGetterName($object, $workflowStateLineStackGetterName);   
        
        $workflowStateLineStack = $object->$workflowStateLineStackGetterName();
        
        return $workflowStateLineStack;
    }
    
    
    /**
     * Check if getter name is valid
     * 
     * @param mixed     $object  Object
     * @param string    $workflowStateLineStackGetterName
     * 
     * @throws InvalidWorkflowLineStackGetterException
     */
    private function checkWorkflowStateLineStackGetterName($object, $workflowStateLineStackGetterName)
    {
        if (method_exists($object, $workflowStateLineStackGetterName) === false) {
            throw new InvalidWorkflowLineStackGetterException($workflowStateLineStackGetterName);
        }
    }
}
