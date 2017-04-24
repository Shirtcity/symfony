<?php

namespace Elcodi\Component\Article\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Article\ImageResolver\Interfaces\ArticleImageResolverInterface;

/**
 * Class ImageResolverExtension.
 */
final class ArticleImageResolverExtension extends Twig_Extension
{
    /**
     * @var ArticleImageResolverInterface
     *
     * Article image resolver
     */
    private $articleImageResolver;

    /**
     * Construct.
     *
     * @param ArticleImageResolverInterface $articleImageResolver Article image resolver
     */
    public function __construct(ArticleImageResolverInterface $articleImageResolver)
    {
        $this->articleImageResolver = $articleImageResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('preview_images', [
                $this->articleImageResolver,
                'getPreviewImages',
            ]),
			new Twig_SimpleFilter('print_side_preview_image', [
                $this->articleImageResolver,
                'getPrintSidePreviewImage',
            ]),
        ];
    }

    /**
     * return extension name.
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'article_image_resolver_extension';
    }
}
