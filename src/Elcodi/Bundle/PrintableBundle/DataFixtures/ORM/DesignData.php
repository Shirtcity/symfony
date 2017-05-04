<?php

namespace Elcodi\Bundle\PrintableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class DesignData.
 */
class DesignData extends AbstractFixture implements DependentFixtureInterface
{
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $designDirector = $this->getDirector('design');
        
        $design = $designDirector
            ->create()
			->setEnabled(true)
            ->setName('Design')
            ->setVectorFileName('design.png')
            ->setPreviewFileName('design.png');

        $designDirector->save($design);
        $this->addReference('design', $design);

    }
    
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\StoreBundle\DataFixtures\ORM\StoreData',
        ];
    }
}
