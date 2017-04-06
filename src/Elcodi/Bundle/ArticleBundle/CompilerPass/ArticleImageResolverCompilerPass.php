<?php

namespace Elcodi\Bundle\ArticleBundle\CompilerPass;

use Elcodi\Bundle\CoreBundle\CompilerPass\Abstracts\AbstractTagCompilerPass;

/**
 * Class ArticleImageResolverCompilerPass.
 */
class ArticleImageResolverCompilerPass extends AbstractTagCompilerPass
{
    /**
     * Get collector service name.
     *
     * @return string Collector service name
     */
    public function getCollectorServiceName()
    {
        return 'elcodi.image_resolver.article';
    }

    /**
     * Get collector method name.
     *
     * @return string Collector method name
     */
    public function getCollectorMethodName()
    {
        return 'addArticleImageResolver';
    }

    /**
     * Get tag name.
     *
     * @return string Tag name
     */
    public function getTagName()
    {
        return 'elcodi.article_image_resolver';
    }
}
