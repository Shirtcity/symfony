<?php

namespace Elcodi\Component\Article\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class AbstractArticleEvent.
 */
abstract class AbstractArticleEvent extends Event
{
    /**
     * @var ArticleInterface
     *
     * article
     */
    private $article;

    /**
     * Construct method.
     *
     * @param ArticleInterface $article Article
     */
    public function __construct(ArticleInterface $article)
    {
        $this->article = $article;
    }

    /**
     * Get article.
     *
     * @return ArticleInterface Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
