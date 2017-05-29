<?php

namespace Elcodi\Bundle\StateTransitionMachineBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateInterface;

/**
 * Class StateData.
 */
class StateData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector    $stateDirector
         */
        
        $stateDirector = $this->getDirector('state');
        
        $states = array(
            array( // row #0
                'name' => 'preparing',
                'icon' => 'rocket',
            ),
            array( // row #1
                'name' => 'unpaid',
                'icon' => 'rocket',
            ),
            array( // row #2
                'name' => 'ready for delivery',
                'icon' => 'rocket',
            ),
            array( // row #3
                'name' => 'ready for produce',
                'icon' => 'rocket',
            ),
            array( // row #4
                'name' => 'production started',
                'icon' => 'rocket',
            ),
            array( // row #5
                'name' => 'order collection ready',
                'icon' => 'rocket',
            ),
            array( // row #6
                'name' => 'working sheet printed',
                'icon' => 'rocket',
            ),
            array( // row #7
                'name' => 'delivery sheet printed',
                'icon' => 'rocket',
            ),
            array( // row #8
                'name' => 'post sheet printed',
                'icon' => 'rocket',
            ),
            array( // row #9
                'name' => 'pdf invoice printed',
                'icon' => 'rocket',
            ),
            array( // row #10
                'name' => 'order producing in progress',
                'icon' => 'rocket',
            ),
            array( // row #11
                'name' => 'produced',
                'icon' => 'rocket',
            ),
            array( // row #12
                'name' => 'cancelled',
                'icon' => 'rocket',
            ),
            array( // row #13
                'name' => 'paused',
                'icon' => 'rocket',
            ),
            array( // row #14
                'name' => 'payment in process',
                'icon' => 'rocket',
            ),
            array( // row #15
                'name' => 'paid',
                'icon' => 'rocket',
            ),
            array( // row #16
                'name' => 'refunded',
                'icon' => 'rocket',
            ),
            array( // row #17
                'name' => 'packed',
                'icon' => 'rocket',
            ),
            array( // row #18
                'name' => 'in delivery',
                'icon' => 'rocket',
            ),
            array( // row #19
                'name' => 'delivered',
                'icon' => 'rocket',
            ),
            array( // row #20
                'name' => 'returned',
                'icon' => 'rocket',
            ),
            array( // row #21
                'name' => 'delivery failed',
                'icon' => 'rocket',
            ),
        );
        
        foreach ($states as $stateData) {
            $state = $stateDirector
                ->create()
                ->setName($stateData['name'])
                ->setIcon($stateData['icon']);

            $stateDirector->save($state);
        }
    }
}
