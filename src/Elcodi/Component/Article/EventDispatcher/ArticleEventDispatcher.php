<?php

namespace Elcodi\Component\Article\EventDispatcher;

use Elcodi\Component\Article\ArticleEvents;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Event\ArticleOnLoadEvent;
use Elcodi\Component\Article\Event\ArticleProductChangeEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class ArticleEventDispatcher.
 */
class ArticleEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch article event after article is loaded.
     *
     * @param ArticleInterface $article Article
     *
     * @return $this Self object
     */
    public function dispatchArticleLoadEvents(ArticleInterface $article)
    {
        $this->dispatchArticleOnLoadEvent($article);

        return $this;
    }
	
	
	/**
     * Dispatch event when Article is loaded.
     *
     * This event considers that all changes related with the entity have
     * been executed. At this point, all related operations can be done, for
     * example, product color validation
     *
     * @param ArticleInterface $article Article
     *
     * @return $this Self object
     */
    public function dispatchArticleOnLoadEvent(ArticleInterface $article)
    {
        $this->eventDispatcher->dispatch(
            ArticleEvents::ARTICLE_ONLOAD,
            new ArticleOnLoadEvent($article)
        );

        return $this;
    }
}
