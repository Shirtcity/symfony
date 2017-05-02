<?php

namespace Elcodi\Component\Article\Services;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Bundle\ProductBundle\Repository\PrintSideTypeRepository;
use Elcodi\Bundle\ProductBundle\Factory\PrintSideFactory;
use Elcodi\Component\Article\Factory\ArticleProductPrintSideFactory;

class ArticleProductPrintSidesManager
{
	/**
	 * @var PrintSideTypeRepository
	 * 
	 * Print Side Type Repository
	 */	
	protected $printSideTypeRepository;

	/**
	 * @var PrintSideFactory
	 * 
	 * PrintSide Factory 
	 */
	protected $printSideFactory;
	
	/**
	 * @var ArticleProductPrintSideFactory 
	 * 
	 * ArticleProductPrintSide Factory
	 */
	protected $articleProductPrintSideFactory;
		
	/**
	 * @var ArticleProductInterface 
	 * 
	 * ArticleProduct
	 */
	private $articleProduct;
	
	/**
     * Constructor
     *
     * @param PrintSideTypeRepository $printSideTypeRepository PrintSideType repository
	 * @param PrintSideFactory $printSideFactory Print Side factory
	 * @param ArticleProductPrintSideFactory $articleProductPrintSideFactory ArticleProductPrintSide factory
     */
    public function __construct( 
		PrintSideTypeRepository $printSideTypeRepository,
		PrintSideFactory $printSideFactory,
		ArticleProductPrintSideFactory $articleProductPrintSideFactory
	) {
        $this->printSideTypeRepository = $printSideTypeRepository;
		$this->printSideFactory = $printSideFactory;
		$this->articleProductPrintSideFactory = $articleProductPrintSideFactory;
	}

	/**
     * Presets article product print sides
	 * 
	 * Generates new print side for each not available for selected product print side types
	 * Existing printable variants will be copied to corresponding product print sides
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     */
	public function preSetArticleProductPrintSides(ArticleProductInterface $articleProduct)
	{
		$this->articleProduct = $articleProduct;
		
		$printSideTypes = $this->printSideTypeRepository
			->findAll();
		
		$productPrintSides = $this->articleProduct
			->getProduct()
			->getPrintSides();
		
		foreach ($printSideTypes as $printSideType) {
			
			$printSideTypeIsAvailable = $productPrintSides
				->exists(function($id, $productPrintSide) use ($printSideType){				
					return $productPrintSide->getType() == $printSideType;
				});			
	
			if(!$printSideTypeIsAvailable) {
				$this->generateMissingPrintSides($printSideType);				
			}			
		}
		
		$this->movePrintableVariantsToCorrespondingPrintSides();	
	}
	
	/**
	 * Generates missing print sides from all existing print side types in the system
	 * 
	 * @param PrintSideType $printSideType
	 */
	private function generateMissingPrintSides($printSideType)
	{
		$printSide = $this
			->printSideFactory
			->create();	
		
		$printSide->setType($printSideType);

		$articleProductPrintSide = $this
			->articleProductPrintSideFactory
			->create();

		$articleProductPrintSide
			->setPrintSide($printSide)
			->setArticleProduct($this->articleProduct);

		$this
			->articleProduct
			->addArticleProductPrintSide($articleProductPrintSide);
	}
	
	/**
	 * Move printable variants to corresponding print sides
	 */
	private function movePrintableVariantsToCorrespondingPrintSides()
	{
		foreach ($this->articleProduct->getArticleProductPrintSides() as $articleProductPrintSide) {
			
			if (null === $articleProductPrintSide->getPrintableVariants()) {
				continue;
			}
					
			$printSideType = $articleProductPrintSide
				->getPrintSide()
				->getType();

			$productPrintSides = $this
				->articleProduct
				->getProduct()
				->getPrintSides();

			$productPrintSides->map(function($productPrintSide) use ($printSideType, $articleProductPrintSide){
				
				if ($productPrintSide->getType() == $printSideType) {					
					$articleProductPrintSide->setPrintSide($productPrintSide);
				}
			});
			
		}
	}
}
