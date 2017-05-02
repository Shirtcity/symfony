<?php

namespace Elcodi\Component\Article;

/**
 * Article Events 
 */
final class ArticleEvents
{
    /**
     * This event is dispatched when the Article is loaded.
     *
     * event.name : article.onload
     * event.class : ArticleOnLoadEvent
     */
    const ARTICLE_ONLOAD = 'article.onload';
	
}
