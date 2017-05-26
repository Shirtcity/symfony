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

namespace Elcodi\Component\Article\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ArticleRepository.
 */
class ArticleRepository extends EntityRepository
{
	/**
     * Get all the the Purchasables from the received categories.
     *
     * @param CategoryInterface[] $categories
     *
     * @return array All Purchasables by a set of category ids
     */
    public function getAllFromCategories(array $categories)
    {		
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder
            ->innerJoin('p.articleProduct', 'ap')
            ->innerJoin('ap.product', 'product')
            ->innerJoin('product.sections', 'c')
            ->where('c.id IN (:categories)')
            ->setParameters([
                'categories' => $categories,
            ])
            ->getQuery()
            ->getResult();
    }	
}
