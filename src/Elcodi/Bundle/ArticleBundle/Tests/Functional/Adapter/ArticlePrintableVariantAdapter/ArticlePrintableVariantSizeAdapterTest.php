<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter;

use Elcodi\Bundle\ArticleBundle\Tests\Functional\Adapter\ArticlePrintableVariantAdapter\ArticlePrintableVariantAdapterTestAbstract;

/**
 * Class ArticlePrintableVariantSizeAdapterTest.
 */
class ArticlePrintableVariantSizeAdapterTest extends ArticlePrintableVariantAdapterTestAbstract
{    
    /**
     * Data for testAdapter.
     */
    public function dataAdapter()
    {
        return [            
            'printable width suits to print area'         => ['Width', 160, 160],
            'printable width doesnt suit to print area'   => ['Width', 860, 190],
            
            'printable height suits to print area'         => ['Height', 200, 200],
            'printable height doesnt suit to print area'   => ['Height', 860, 190],            
        ];
    }
}
