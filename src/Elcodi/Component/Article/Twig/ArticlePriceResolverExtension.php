<?php

namespace Elcodi\Component\Article\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Article\PriceResolver\Interfaces\ArticlePriceResolverInterface;

/**
 * Class ArticlePriceResolverExtension.
 */
final class ArticlePriceResolverExtension extends Twig_Extension
{
    /**
     * @var ArticlePriceResolverInterface
     *
     * Article Price resolver
     */
    private $articlePriceResolver;

    /**
     * Construct.
     *
     * @param ArticlePriceResolverInterface $articlePriceResolver Article Price resolver
     */
    public function __construct(ArticlePriceResolverInterface $articlePriceResolver)
    {
        $this->articlePriceResolver = $articlePriceResolver;
    }

    /**
     * Returns defined twig functions.
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('article_price', [
                $this->articlePriceResolver,
                'getPrice',
            ]),
			new Twig_SimpleFilter('article_reduced_price', [
                $this->articlePriceResolver,
                'getReducedPrice',
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
        return 'article_price_resolver_extension';
    }
}
