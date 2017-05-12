<?php

namespace Elcodi\Bundle\ArticleBundle\Tests\Functional\ImageResolver;

use Doctrine\Common\Collections\ArrayCollection;
use \Prophecy\Argument;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Article\ImageResolver\ArticleImageResolver;


/**
 * Class ArticleImageResolverTest.
 */
class ArticleImageResolverTest extends WebTestCase
{	
	/**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiArticleBundle',
        ];
    }
	
    /**
     * Test resolve image.
     *
     * @dataProvider dataResolveImage
     */
    public function testResolveImage(
        $emptyArticle,
        $result,
		$imagesCount,
		$image
    ) {        

        $imageResolver = $this->prophesize('Elcodi\Component\Media\Services\ImageResolver');
		$imageManager = $this->prophesize('Elcodi\Component\Media\Services\ImageManager');
		
		$article = ($emptyArticle === true) 
			? $this->getMockBuilder('Elcodi\Component\Article\Entity\Article')->disableOriginalConstructor(true)->getMock()
			: $this->find('article', 2);
		

		$imageManager->combine(
				Argument::any(), 
				Argument::any(), 
				Argument::any()
			)
			->willReturn($image);
		
		$articleImageResolver = new ArticleImageResolver(
			$imageResolver->reveal(), 
			$imageManager->reveal()
		);
		
		$articleImages = $articleImageResolver->getPreviewImages($article);
		
        $this->assertEquals(
			$result,
			$articleImages
        );

        $this->assertEquals(
			$imagesCount, 
			count($articleImages)
		);
		
		$this->assertEquals(
            $image,
            $articleImageResolver->getPrintSidePreviewImage(
				$article,
				'front'
			)
        );
    }

    /**
     * Data for testResolveImage.
     */
    public function dataResolveImage()
    {
        $image = $this
            ->prophesize('Elcodi\Component\Media\Entity\Interfaces\ImageInterface')
            ->reveal();	
		
        return [
            'article is empty, no image'	=> [true, null, 0, null],
            'article with 4 print sides'	=> [false, new ArrayCollection([$image]), 1, $image],
        ];
    }
	
}
