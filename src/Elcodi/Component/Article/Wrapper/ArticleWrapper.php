<?php

namespace Elcodi\Component\Article\Wrapper;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\EventDispatcher\ArticleEventDispatcher;
use Elcodi\Component\Article\Factory\ArticleFactory;
use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
use Elcodi\Component\Article\Factory\ArticleProductPrintSideFactory;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;


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
 * * getArticleProductPrintSide()
 *
 * @api
 */
class ArticleWrapper implements WrapperInterface
{
	/**
     * @var ArticleInterface
     *
     * Article loaded
     */
    private $article;
	
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
     * @var ArticleProductPrintSide
     *
     * ArticleProductPrintSide
     */
    private $articleProductPrintSide;
	
	/**
     * @var ArticleProductPrintSideFactory
     *
     * ArticleProductPrintSide Factory
     */
    private $articleProductPrintSideFactory;    

    /**
     * Construct method.
     *
     * @param ArticleEventDispatcher $articleEventDispatcher Article EventDispatcher
     * @param ArticleFactory         $articleFactory         Article Factory
     * @param ArticleProductPrintSideFactory  $articleProductPrintSideFactory  ArticleProductPrintSide Factory 
     */
    public function __construct(
        ArticleEventDispatcher $articleEventDispatcher,
        ArticleFactory $articleFactory,
		ArticleProductPrintSideFactory $articleProductPrintSideFactory
    ) {
        $this->articleEventDispatcher = $articleEventDispatcher;
        $this->articleFactory = $articleFactory;
		$this->articleProductPrintSideFactory = $articleProductPrintSideFactory;
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

        $this->resolveArticle();

        $this
            ->articleEventDispatcher
            ->dispatchArticleLoadEvents($this->article);

        return $this->article;
    }
	
	public function getArticleProduct()
	{
		if(null === $this->article) {
			$this->resolveArticle();
		}
		
		return $this->article->getArticleProduct();
	}
	
	/**
	 * Get Article Product Print Side
	 * 
	 * @return ArticleProductPrintSide object
	 */
	public function getArticleProductPrintSide()
	{
		if(null === $this->article) {
			$this->resolveArticle();
		}	
		
		if ($this->articleProductPrintSide instanceof ArticleProductPrintSideInterface) {
            return $this->articleProductPrintSide;
        }
		
		$this->resolveArticleProductPrintSides();
		
		return $this->articleProductPrintSide;
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
        $this->article = $this
			->articleFactory
			->create();		
    }
	
	private function resolveArticleProductPrintSides()
	{			
		$this->articleProductPrintSide = $this
			->articleProductPrintSideFactory
			->create();
		
		$this->articleProductPrintSide->setArticleProduct($this->article->getArticleProduct());
	}
}
