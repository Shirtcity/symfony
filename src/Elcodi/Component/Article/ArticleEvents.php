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
	
	/**
     * This event is dispatched after Article Product has been changed
     *
     * event.name : article.product_change
     * event.class : ArticleProductChangeEvent
     */
    const ARTICLE_PRODUCT_CHANGE = 'article.product_change';    
}
