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
final class ElcodiArticleTypes
{
    /**
     * @var int
     *
     * Physical article type
     */
    const TYPE_PRODUCT_PHYSICAL = 0;

    /**
     * @var int
     *
     * Virtual article type
     */
    const TYPE_PRODUCT_VIRTUAL = 1;

    /**
     * @var int
     *
     * Downloadable article type
     */
    const TYPE_PRODUCT_DOWNLOAD = 2;
}
