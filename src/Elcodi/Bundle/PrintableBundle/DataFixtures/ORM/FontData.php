<?php

namespace Elcodi\Bundle\PrintableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class TextData.
 */
class FontData extends AbstractFixture implements DependentFixtureInterface
{
	/**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fontDirector = $this->getDirector('font');
        
        $font = $fontDirector
            ->create()
			->setName('Arial')
            ->setMinSize(5)
            ->setFontFileName('1_font_arial.ttf')
            ->setEnabled(true);

        $fontDirector->save($font);
        $this->addReference('font', $font);

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
