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

namespace Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Machine;

use \Prophecy\Argument;

use Elcodi\Component\StateTransitionMachine\Machine\MachineBuilder;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;
use Elcodi\Component\StateTransitionMachine\Factory\StateFactory;

/**
 * Class MachineBuilderTest.
 */
class MachineBuilderTest extends AbstractStateTransitionTest
{
    /**
     * Test the compilation without errors.
     *
     * for example:
     *
     * $configuration = array(
     *      'state1', 'action3', 'state2',
     *      'state2', 'action2', 'state3',
     *      'state3', 'action3', 'state1',
     *      'state3', 'action4', 'state4',
     * );
     *
     * @param array $configuration Configuration
     *
     * @dataProvider dataCompileOk
     */
    public function testCompileOk($configuration)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
                
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            $configuration,
            'unpaid'
        );
        
        $machineBuilder->allowCycles(true);
        $machineBuilder->compile();
    }

    /**
     * data for testCompileOk.
     */
    public function dataCompileOk()
    {
        return [
            [
                [
                    ['unpaid', 'pay', 'paid'],
                    ['unpaid', 'revise', 'revised'],
                    ['revised', 'pay', 'paid'],
                    ['paid', 'ship', 'shipped'],
                ],
            ],
            [
                [
                    ['unpaid', 'pay', 'paid'],
                    ['paid', 'return', 'unpaid'],
                ],
            ],
        ];
    }

    /**
     * Test failure with non-valid transitions.
     *
     * @param string $transition Transition
     *
     * @dataProvider dataTransitionNonValid
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\TransitionNotValidException
     */
    public function testTransitionNonValid($transition)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            [$transition],
            'unpaid'
        );

        $machineBuilder->compile();
    }

    /**
     * data for testTransitionNonValid.
     */
    public function dataTransitionNonValid()
    {
        return [
            [''],
            [null],
            [true],
            [false],
            [[]],
            [['']],
            [['unpaid']],
            [[null]],
            [[true]],
            [[false]],
            [[0]],
            [['unpaid', 'pay']],
            [['unpaid', null]],
            [['unpaid', true]],
            [['unpaid', false]],
            [['unpaid', 0]],
            [['unpaid', 'pay', null]],
            [['unpaid', 'pay', true]],
            [['unpaid', 'pay', false]],
            [['unpaid', 'pay', 0]],
        ];
    }

    /**
     * Test invalid point of entry.
     *
     * @param array  $configuration Configuration
     * @param string $pointOfEntry  Point of entry
     *
     * @dataProvider dataInvalidPointOfEntry
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\InvalidPointOfEntryException
     */
    public function testInvalidPointOfEntry($configuration, $pointOfEntry)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            $configuration,
            $pointOfEntry
        );

        $machineBuilder->allowCycles(true);
        $machineBuilder->compile();
    }

    /**
     * data for testInvalidPointOfEntry.
     */
    public function dataInvalidPointOfEntry()
    {
        return [
            [
                [
                    ['unpaid', 'pay', 'paid'],
                ],
                'paid',
            ],
            [
                [
                    ['unpaid', 'pay', 'paid'],
                ],
                '',
            ],
            [
                [
                    ['unpaid', 'pay', 'paid'],
                ],
                null,
            ],
            [
                [
                    ['unpaid', 'pay', 'paid'],
                ],
                false,
            ],
            [
                [
                    ['unpaid', 'pay', 'paid'],
                ],
                true,
            ],
        ];
    }

    /**
     * Test failure with non-allowed cycles.
     *
     * @param array $configuration Configuration
     *
     * @dataProvider dataCyclesNotAllowed
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\CyclesNotAllowedException
     */
    public function testCyclesNotAllowed($configuration)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            $configuration,
            'unpaid'
        );

        $machineBuilder->allowCycles(false);
        $machineBuilder->compile();
    }

    /**
     * data for testCyclesNotAllowed.
     */
    public function dataCyclesNotAllowed()
    {
        return [
            [
                [
                    ['unpaid', 'pay', 'paid'],
                    ['paid', 'return', 'unpaid'],
                ],
            ],
        ];
    }

    /**
     * Test failure with inconsistent transitions.
     *
     * @param array $configuration Configuration
     *
     * @dataProvider dataInconsistentTransitions
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\InconsistentTransitionConfigurationException
     */
    public function testInconsistentTransitions($configuration)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            $configuration,
            'unpaid'
        );

        $machineBuilder->allowCycles(false);
        $machineBuilder->compile();
    }

    /**
     * data for testInconsistentTransitions.
     */
    public function dataInconsistentTransitions()
    {
        return [
            [
                [
                    ['unpaid', 'pay', 'paid'],
                    ['unpaid', 'pay', 'shipped'],
                ],
            ],
        ];
    }

    /**
     * Test failure with invalid states.
     *
     * @param array $configuration Configuration
     *
     * @dataProvider dataInvalidStates
     * @expectedException \Elcodi\Component\StateTransitionMachine\Exception\StateNotValidException
     */
    public function testInvalidStates($configuration)
    {
        $machineFactory = $this->createMock('Elcodi\Component\StateTransitionMachine\Factory\MachineFactory');
        $machineBuilder = new MachineBuilder(
            $machineFactory,
            $this->getStateRepository(),
            'id',
            $configuration,
            'unpaid'
        );

        $machineBuilder->compile();
    }

    /**
     * data for testInvalidStates.
     */
    public function dataInvalidStates()
    {
        return [
            [
                [
                    ['unpaid', 'pay', 'paid'],
                    ['another', 'pay', 'shipped'],
                ],
            ],
        ];
    }
}
