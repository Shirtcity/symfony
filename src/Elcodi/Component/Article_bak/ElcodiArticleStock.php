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

namespace Elcodi\Component\Article;

/**
 * Class ElcodiArticleTypes.
 */
final class ElcodiArticleStock
{
    /**
     * @var null
     *
     * Infinite stock
     */
    const INFINITE_STOCK = null;

    /**
     * @var int
     *
     * Inherit stock
     */
    const INHERIT_STOCK = 0;

    /**
     * @var int
     *
     * Specific stock
     */
    const SPECIFIC_STOCK = 1;
}
