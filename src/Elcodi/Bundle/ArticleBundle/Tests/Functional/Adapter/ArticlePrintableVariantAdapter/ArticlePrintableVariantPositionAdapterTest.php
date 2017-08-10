<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter;

use Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter\ArticlePrintableVariantAdapterTestAbstract;

/**
 * Class ArticlePrintableVariantPositionAdapterTest.
 */
class ArticlePrintableVariantPositionAdapterTest extends ArticlePrintableVariantAdapterTestAbstract
{    
    /**
     * Data for testAdapter.
     */
    public function dataAdapter()
    {
        return [            
            'printable posX suits to print area'         => ['posX', 160, 160],
            'printable posX doesnt suit to print area'   => ['posX', 860, 155],
            
            'printable posY suits to print area'         => ['posY', 200, 200],
            'printable posY doesnt suit to print area'   => ['posY', 860, 100],            
        ];
    }
}
