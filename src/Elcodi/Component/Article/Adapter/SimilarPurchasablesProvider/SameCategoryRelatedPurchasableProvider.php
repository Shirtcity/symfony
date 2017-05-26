<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Article\Adapter\SimilarPurchasablesProvider;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Article\Adapter\SimilarPurchasablesProvider\Interfaces\RelatedPurchasablesProviderInterface;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Article\Repository\PurchasableRepository;
use Elcodi\Component\Article\Repository\ArticleRepository;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;

/**
 * Class SameCategoryRelatedPurchasableProvider.
 *
 * This adapter takes in account only the principal category of the purchasable.
 */
class SameCategoryRelatedPurchasableProvider implements RelatedPurchasablesProviderInterface
{
    /**
     * @var PurchasableRepository
     *
     * Purchasable Repository
     */
    private $purchasableRepository;
	
	/**
     * @var ArticleRepository
     *
     * Article Repository
     */
    private $articleRepository;

    /**
     * Construct method.
     *
     * @param PurchasableRepository $purchasableRepository Purchasable Repository
	 * @param ArticleRepository $articleRepository Article Repository
     */
    public function __construct(PurchasableRepository $purchasableRepository, ArticleRepository $articleRepository)
    {
        $this->purchasableRepository = $purchasableRepository;
		$this->articleRepository = $articleRepository;
    }

    /**
     * Given a Purchasable, return a collection of related purchasables.
     *
     * @param PurchasableInterface $purchasable Purchasable
     * @param int                  $limit       Limit of elements retrieved
     *
     * @return array Related purchasables
     */
    public function getRelatedPurchasables(PurchasableInterface $purchasable, $limit)
    {
        return $this->getRelatedPurchasablesFromArray(
            [$purchasable],
            $limit
        );
    }

    /**
     * Given a Collection of Purchasables, return a collection of related
     * purchasables.
     *
     * @param PurchasableInterface[] $purchasables Purchasable
     * @param int                    $limit        Limit of elements retrieved
     *
     * @return array Related articles
     */
    public function getRelatedPurchasablesFromArray(array $purchasables, $limit)
    {
        $categories = [];

        /**
         * @var PurchasableInterface $article
         */
        foreach ($purchasables as $purchasable) {
			if ($purchasable instanceof ArticleInterface !== true) {
				continue;
			}
			
            $category = $purchasable->getArticleProduct()->getProduct()->getSections()->first();
            if (
                $category instanceof CategoryInterface &&
                !in_array($category, $categories)
            ) {
                $categories[] = $category;
            }
        }

        if (empty($categories)) {
            return [];
        }
	
        return $this
            ->articleRepository
            ->createQueryBuilder('a')
            ->innerJoin('a.articleProduct', 'ap')
            ->innerJoin('ap.product', 'product')
			->innerJoin('product.sections', 'c')
            ->where('c IN(:categories)')
            ->andWhere('a NOT IN(:purchasables)')
            ->andWhere('a.enabled = :enabled')
            ->setParameters([
                'categories' => $categories,
                'purchasables' => $purchasables,
                'enabled' => true,
            ])
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
