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

use Elcodi\Component\EntityTranslator\Services\EntityTranslator;
use Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle;

/**
 * Class TranslatorTest.
 */
class TranslatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test translate.
     */
    public function testTranslate()
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', [], [], '', false);
        $entityTranslationProvider
            ->expects($this->once())
            ->method('getTranslation')
            ->with(
                $this->equalTo('article'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('en')
            )
            ->will($this->returnValue('translatedArticleName'));

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

        $translator = new EntityTranslator(
            $entityTranslationProvider,
            $configuration,
            true
        );

        $article = new TranslatableArticle();
        $article
            ->setId(1)
            ->setName('articleName');

        $translatedArticle = $translator->translate($article, 'en');
        $this->assertSame($article, $translatedArticle);
        $this->assertEquals('translatedArticleName', $translatedArticle->getName());
    }

    /**
     * Test the save method.
     */
    public function testSave()
    {
        $entityTranslationProvider = $this->getMock('Elcodi\Component\EntityTranslator\Services\EntityTranslationProvider', [], [], '', false);
        $entityTranslationProvider
            ->expects($this->exactly(4))
            ->method('setTranslation')
            ->withConsecutive([
                $this->equalTo('article'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('el nombre'),
                $this->equalTo('es'),
            ], [
                $this->equalTo('article'),
                $this->equalTo('1'),
                $this->equalTo('description'),
                $this->equalTo('la descripción'),
                $this->equalTo('es'),
            ], [
                $this->equalTo('article'),
                $this->equalTo('1'),
                $this->equalTo('name'),
                $this->equalTo('the name'),
                $this->equalTo('en'),
            ], [
                $this->equalTo('article'),
                $this->equalTo('1'),
                $this->equalTo('description'),
                $this->equalTo('the description'),
                $this->equalTo('en'),
            ]);

        $entityTranslationProvider
            ->expects($this->once())
            ->method('flushTranslations');

        $configuration = [
            'Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableArticle' => [
                'alias' => 'article',
                'idGetter' => 'getId',
                'fields' => [
                    'name' => [
                        'setter' => 'setName',
                        'getter' => 'getName',
                    ],
                    'description' => [
                        'setter' => 'setDescription',
                        'getter' => 'getDescription',
                    ],
                ],
            ],
        ];

        $translator = new EntityTranslator(
            $entityTranslationProvider,
            $configuration,
            true
        );

        $article = new TranslatableArticle();
        $article
            ->setId(1)
            ->setName('wrong name')
            ->setDescription('wrong description');

        $translator->save($article, [
            'es' => [
                'name' => 'el nombre',
                'description' => 'la descripción',
            ],
            'en' => [
                'name' => 'the name',
                'description' => 'the description',
                'anotherfield' => 'some value',
            ],
        ]);
    }
}
