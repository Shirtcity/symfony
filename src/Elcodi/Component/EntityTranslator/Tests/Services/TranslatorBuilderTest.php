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

namespace Elcodi\Component\EntityTranslator\Tests\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\EntityTranslator\Services\EntityTranslatorBuilder;

/**
 * Class TranslatorBuilderTest.
 */
class TranslatorBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test compilation ok.
     */
    public function testCompileOk()
    {
        $entityTranslationProvider = $this
			->getMockBuilder('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
				
        $translatorFactory = $this
			->getMockBuilder('Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
        $translator = $this
			->getMockBuilder('Elcodi\Component\EntityTranslator\Services\EntityTranslator')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();

        $translatorFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($translator));

        $configuration = [
            'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                'alias' => 'article',
                'idGetter' => 'getId',
                'fields' => [
                    'name' => [
                        'setter' => 'setName',
                        'getter' => 'getName',
                    ],
                ],
            ],
        ];

        $translatorBuilder = new EntityTranslatorBuilder(
            $entityTranslationProvider,
            $translatorFactory,
            $configuration,
            true

        );
        $translator = $translatorBuilder->compile();
        $this->assertInstanceOf('Elcodi\Component\EntityTranslator\Services\EntityTranslator', $translator);
    }

    /**
     * Test compilation fail.
     *
     * @dataProvider dataCompileException
     * @expectedException \Elcodi\Component\EntityTranslator\Exception\TranslationDefinitionException
     */
    public function testCompileException($configuration)
    {
        $entityTranslationProvider = $this
			->getMockBuilder('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();
				
        $translatorFactory = $this
			->getMockBuilder('Elcodi\Component\EntityTranslator\Factory\EntityTranslatorFactory')
			->setMethods([])
			->setMockClassName('')
			->disableOriginalConstructor(true)
			->getMock();			

        $translatorBuilder = new EntityTranslatorBuilder(
            $entityTranslationProvider,
            $translatorFactory,
            $configuration,
            true
        );
        $translatorBuilder->compile();
    }

    /**
     * data testCompileException.
     */
    public function dataCompileException()
    {
        return [
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\NonExistingArticle' => [
                        'alias' => 'article',
                        'getterId' => 'getId',
                        'fields' => [
                            'name' => [
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                        'alias' => 'article',
                        'getterId' => 'nonExistingGetId',
                        'fields' => [
                            'name' => [
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                        'alias' => '',
                        'fields' => [
                            'name' => [
                                'setter' => 'setName',
                                'getter' => 'getName',
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                        'alias' => 'article',
                        'fields' => [
                            'name' => [
                                'setter' => 'nonExistingSetName',
                                'getter' => 'getName',
                            ],
                        ],
                    ],
                ],
            ],
            [
                [
                    'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                        'alias' => 'article',
                        'fields' => [
                            'name' => [
                                'setter' => 'setName',
                                'getter' => 'nonExistingGetName',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
