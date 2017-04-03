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

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\EventListener;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Repository\CategoryRepository;

/**
 * Class ArticleCategoryIntegrityEventListenerTest.
 */
class ArticleCategoryIntegrityEventListenerTest extends WebTestCase
{
    /**
     * @var CategoryRepository
     *
     * Category repository class
     */
    protected $categoryRepository;

    /**
     * @var ObjectDirector
     *
     * The article director.
     */
    protected $articleDirector;

    /**
     * Setup.
     */
    public function setUp()
    {
        parent::setUp();

        $this->categoryRepository = $this->get('elcodi.repository.category');
        $this->articleDirector = $this->get('elcodi.director.article');
    }

    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiArticleBundle',
        ];
    }

    /**
     * Test that the principal category is assigned when a article is saved
     * with categories but not principal category.
     */
    public function testArticleIsSavedWithoutPrincipalCategoryButCategories()
    {
        $category = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'category']);

        /**
         * @var ArticleInterface $article
         */
        $article = $this->getNewArticle();
        $article->addCategory($category);
        $article->setSlug('new-article-1');
        $article->setName('New article 1');

        $this->articleDirector->save($article);

        $article = $this
            ->articleDirector
            ->findOneBy(['slug' => 'new-article-1']);

        $this->assertEquals(
            $category,
            $article->getPrincipalCategory(),
            'The article does not have the expected principal category'
        );
    }

    /**
     * Test that the principal category is assigned as category when a article
     * is saved only with principal category.
     */
    public function testArticleIsSavedOnlyWithPrincipalCategory()
    {
        $category = $this
            ->categoryRepository
            ->findOneBy(['slug' => 'category']);

        /**
         * @var ArticleInterface $article
         */
        $article = $this->getNewArticle();
        $article->setPrincipalCategory($category);
        $article->setSlug('new-article-2');
        $article->setName('New article 2');

        $this->articleDirector->save($article);

        $article = $this
            ->articleDirector
            ->findOneBy(['slug' => 'new-article-2']);

        $this->assertEquals(
            1,
            $article->getCategories()->count(),
            'The article is expected to have one category'
        );

        $this->assertEquals(
            $category,
            $article->getCategories()->first(),
            'The returned category should be the principal category'
        );
    }

    /**
     * Gets a new article entity.
     *
     * @return ArticleInterface
     */
    public function getNewArticle()
    {
        return $this
            ->articleDirector
            ->create();
    }
}
