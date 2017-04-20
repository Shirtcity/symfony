<?php

namespace Elcodi\Component\Article\EventListener;

//use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Event\PreFlushEventArgs;

use Elcodi\Component\Article\Event\ArticleProductChangeEvent;
use Elcodi\Component\Article\Event\Abstracts\AbstractArticleEvent;
use Elcodi\Component\Article\Services\ArticleManager;
use Elcodi\Component\Article\Entity\ArticleProduct;
use Elcodi\Component\Article\Entity\Article;

/**
 * Class ValidateArticleProductColorEventListener.
 */
class ValidateArticleProductColorEventListener 
{
    /**
     * @var ArticleManager
     *
     * Article manager
     */
    private $articleProductColorValidator;

    /**
     * Construct.
     *
     * @param $articleProductColorValidator 
     */
    public function __construct($articleProductColorValidator)
    {
        $this->articleProductColorValidator = $articleProductColorValidator;
    }
	
    /**
     * Update article product color
     */
    public function validateArticleProductColor(AbstractArticleEvent $event)
    {
		$this
			->articleProductColorValidator
			->validateArticleProductColor($event->getArticle());
    } 
	
	
}
