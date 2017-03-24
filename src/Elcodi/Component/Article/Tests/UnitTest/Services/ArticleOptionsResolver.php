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

namespace Elcodi\Component\Article\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Attribute\Entity\Value;
use Elcodi\Component\Article\Services\ArticleOptionsResolver;

/**
 * Class ArticleOptionsResolverTest
 */
class ArticleOptionsResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test for Article twig extension
     */
    public function testAvailableOptions()
    {
        $article = $this->getMockBuilder('Elcodi\Component\Article\Entity\Article')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
        $attribute = $this->getMockBuilder('Elcodi\Component\Attribute\Entity\Attribute')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
		
        $option = new Value();
        $option->setId(111);
        $option->setAttribute($attribute);

        $articleOptionsResolver = new ArticleOptionsResolver();
        $this->assertEquals(
            new ArrayCollection([$option]),
            $articleOptionsResolver->getAvailableOptions(
                $article,
                $attribute
            )
        );
    }
}
