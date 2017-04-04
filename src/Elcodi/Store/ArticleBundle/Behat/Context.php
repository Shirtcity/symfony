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

namespace Elcodi\Store\ArticleBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityNotFoundException;
use Exception;

use Elcodi\Bridge\BehatBridgeBundle\Abstracts\AbstractElcodiContext;
use Elcodi\Bundle\CategoryBundle\Entity\Interfaces\CategoryInterface;
use Elcodi\Component\Article\Entity\Interfaces\ArticleInterface;
use Elcodi\Component\Article\Entity\Interfaces\PurchasableInterface;

/**
 * Class Context
 */
class Context extends AbstractElcodiContext
{
    /**
     * @Given ~^I am on the article (?P<articleId>\d+) page$~
     */
    public function iAmOnTheArticlePage($articleId)
    {
        $article = $this->getPurchasable($articleId);

        $this
            ->getSession()
            ->visit($this->getRoute('store_article_view', [
                'id' => $articleId,
                'slug' => $article->getSlug(),
            ]));
    }

    /**
     * @Given ~^I am on the pack (?P<packId>\d+) page$~
     */
    public function iAmOnThePackPage($packId)
    {
        $pack = $this->getPurchasable($packId);

        $this
            ->getSession()
            ->visit($this->getRoute('store_purchasable_pack_view', [
                'id' => $packId,
                'slug' => $pack->getSlug(),
            ]));
    }

    /**
     * @Then ~^I should see more than (?P<numberOfArticles>\d+) articles$~
     */
    public function iShouldSeeMoreThanXArticles($numberOfArticles)
    {
        $elements = $this->getItemElements();

        if (count($elements) <= $numberOfArticles) {
            throw new Exception(
                sprintf(
                    'Displayed %d articles, minimum expected %d',
                    count($elements),
                    $numberOfArticles + 1
                )
            );
        }
    }

    /**
     * @Then ~^I should see less than (?P<numberOfArticles>\d+) articles$~
     */
    public function iShouldSeeLessThanXArticles($numberOfArticles)
    {
        $elements = $this->getItemElements();

        if (count($elements) >= $numberOfArticles) {
            throw new Exception(
                sprintf(
                    'Displayed %d articles, maximum expected %d',
                    count($elements),
                    $numberOfArticles - 1
                )
            );
        }
    }

    /**
     * @Then ~^I should see exactly (?P<numberOfArticles>\d+) articles$~
     */
    public function iShouldSeeExactlyXArticles($numberOfArticles)
    {
        $elements = $this->getItemElements();

        if (count($elements) != $numberOfArticles) {
            throw new Exception(
                sprintf(
                    'Displayed %d articles, expected %d',
                    count($elements),
                    $numberOfArticles
                )
            );
        }
    }

    /**
     * @Then ~^I should see article (?P<id>\d+) name$~
     * @Then ~^I should see pack (?P<id>\d+) name$~
     * @Then ~^I should see purchasable (?P<id>\d+) name$~
     */
    public function iShouldSeePurchasableName($id)
    {
        $purchasable = $this->getPurchasable($id);

        $this
            ->getSession()
            ->getPage()
            ->findAll('xpath', '//h1[contains(., "' . $purchasable->getName() . '")]');
    }

    /**
     * @Then ~^I should see category menu item$~
     */
    public function iShouldSeeCategoryMenuItem(TableNode $table)
    {
        foreach ($table as $node) {
            $categoryName = $node['name'];
            $active = $node['active'];

            $activeXpath = $active == 'true'
                ? 'a[contains(@class, "active")]'
                : 'a[not(contains(@class, "active"))]';

            $element = $this
                ->getSession()
                ->getPage()
                ->find(
                    'xpath',
                    '//ul[contains(@class, "category-nav")]/li/' . $activeXpath . '[contains(text(), "' . $categoryName . '")]'
                );

            if (is_null($element)) {
                $activeExpression = $active
                    ? 'active'
                    : 'non active';

                throw new Exception(
                    sprintf(
                        'Category with name "%s" not found as a %s root menu',
                        $categoryName,
                        $activeExpression
                    )
                );
            }
        }
    }

    /**
     * Get purchasable by id
     *
     * @param integer $purchasableId Purchasable Id
     *
     * @return PurchasableInterface Purchasable
     *
     * @throws EntityNotFoundException Article not found
     */
    protected function getPurchasable($purchasableId)
    {
        $purchasable = $this
            ->getContainer()
            ->get('elcodi.repository.purchasable')
            ->find($purchasableId);

        if (!($purchasable instanceof PurchasableInterface)) {
            throw new EntityNotFoundException(
                sprintf(
                    'Purchasable with id %d was not found',
                    $purchasableId
                )
            );
        }

        return $purchasable;
    }

    /**
     * Get category by id
     *
     * @param integer $categoryId Category Id
     *
     * @return CategoryInterface Category
     *
     * @throws EntityNotFoundException Category not found
     */
    protected function getCategory($categoryId)
    {
        $category = $this
            ->getContainer()
            ->get('elcodi.repository.category')
            ->find($categoryId);

        if (!($category instanceof ArticleInterface)) {
            throw new EntityNotFoundException(
                sprintf(
                    'Category with id %d was not found',
                    $categoryId
                )
            );
        }

        return $category;
    }

    /**
     * @return \Behat\Mink\Element\NodeElement[]
     */
    protected function getItemElements()
    {
        $elements = $this
            ->getSession()
            ->getPage()
            ->findAll('xpath', '//div[contains(@class, "article-item")]');

        return $elements;
    }
}
