<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Plugin\ArticleCsvBundle\Services;

use DateTime;
use Goodby\CSV\Export\Protocol\ExporterInterface;

use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Converts Article lists into CSV
 *
 * @author Berny Cantos <be@rny.cc>
 */
class ArticleExporter
{
    /**
     * @var ExporterInterface
     *
     * CSV exporter
     */
    protected $exporter;

    /**
     * @param ExporterInterface $exporter
     */
    public function __construct(ExporterInterface $exporter)
    {
        $this->exporter = $exporter;
    }

    /**
     * Export a Article list to standard output formatted as CSV
     *
     * @param ArticleInterface[] $articles article list
     */
    public function export(array $articles)
    {
        $rows = $this->serializeRows($articles);

        $this->exporter->export('php://output', $rows);
    }

    /**
     * Convert from a Article list to a plain array
     *
     * @param ArticleInterface[] $articles article list
     *
     * @return array
     */
    protected function serializeRows(array $articles)
    {
        $result = [];
        foreach ($articles as $article) {
			$price = $this
				->get('price_resolver.article')
				->getReducedPrice($article);
			
            $result[] = [
                'id' => $article->getId(),
                'sku' => $article->getSku(),
                'name' => $article->getName(),
                'slug' => $article->getSlug(),
                'description' => $article->getDescription(),
                'price' => $price->getAmount(),
                'currency' => $price->getCurrency()->getSymbol(),
                'reducedPrice' => $article->getReducedPrice()->getAmount(),
                'reducedPriceCurrency' => $article->getReducedPrice()->getCurrency()->getSymbol(),
                'principalCategory' => $article->getPrincipalCategory()->getName(),
                'showInHome' => $article->getShowInHome() ? 'yes' : 'no',
                'weight' => $article->getWeight(),
                'depth' => $article->getDepth(),
                'width' => $article->getWidth(),
                'height' => $article->getHeight(),
                'createdAt' => $article->getCreatedAt()->format(DateTime::ATOM),
                'updatedAt' => $article->getUpdatedAt()->format(DateTime::ATOM),
                'enabled' => $article->isEnabled() ? 'yes' : 'no',
            ];
        }

        // Add row with keys at the top
        if (!empty($result)) {
            $keys = array_keys($result[0]);
            array_unshift($result, $keys);
        }

        return $result;
    }
}
