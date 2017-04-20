<?php

namespace Elcodi\Component\Article\Wrapper;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\EventDispatcher\ArticleEventDispatcher;
use Elcodi\Component\Article\Factory\ArticleFactory;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Wrapper\CustomerWrapper;

/**
 * Class ArticleWrapper.
 *
 * Envelopes a Article object and provides the minimum logic to
 * load it from HTTP Session, from the Customer collection
 * of pending Articles or by factoring a pristine Article.
 *
 * The most useful method in this wrapper is get(), which
 * will behave according to different scenarios:
 *
 * - When the Customer has pending Articles, the last Article form
 *   this collection is returned
 * - When there is a Article in session, it is associated with
 *   the Customer and is returned
 * - When there is no Article in session, a new one is factored
 *
 * Api Methods:
 *
 * * get()
 * * clean()
 *
 * @api
 */
class ArticleWrapper implements WrapperInterface
{
    /**
     * @var ArticleEventDispatcher
     *
     * Article EventDispatcher
     */
    private $articleEventDispatcher;

    /**
     * @var ArticleFactory
     *
     * Article Factory
     */
    private $articleFactory;

    /**
     * @var ArticleInterface
     *
     * Article loaded
     */
    private $article;

    /**
     * Construct method.
     *
     * @param ArticleEventDispatcher $articleEventDispatcher Article EventDispatcher
     * @param ArticleFactory         $articleFactory         Article Factory
     * @param ArticleSessionWrapper  $articleSessionWrapper  Article Session Wrapper
     */
    public function __construct(
        ArticleEventDispatcher $articleEventDispatcher,
        ArticleFactory $articleFactory
    ) {
        $this->articleEventDispatcher = $articleEventDispatcher;
        $this->articleFactory = $articleFactory;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        if ($this->article instanceof ArticleInterface) {
            return $this->article;
        }

        $this->article = $this->resolveArticle();

        $this
            ->articleEventDispatcher
            ->dispatchArticleLoadEvents($this->article);

        return $this->article;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        $this->article = null;

        return $this;
    }    

    /**
     * Resolves an article
     *
     * @return ArticleInterface Article resolved
     */
    private function resolveArticle() 
	{
        $article = $this
			->articleFactory
			->create();
            
        return $article;
    }
}
