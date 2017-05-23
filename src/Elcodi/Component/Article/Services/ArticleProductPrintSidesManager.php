<?php

namespace Elcodi\Component\Article\Services;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductInterface;
use Elcodi\Bundle\ProductBundle\Repository\PrintSideTypeRepository;
use Elcodi\Bundle\ProductBundle\Factory\PrintSideFactory;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideTypeInterface;
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
     * Generates default empty print sides for an article product
     * 
     * @param ArticleProductInterface $articleProduct
     * @return $this
     */
    public function generateDefaultPrintSides(ArticleProductInterface $articleProduct)
    {
        $productPrintSides = $articleProduct
            ->getProduct()
            ->getPrintSides();
     
		if($articleProduct->getArticleProductPrintSides()->isEmpty()) {

			$productPrintSides->map(function($printSide) use ($articleProduct){
				
                $articleProductPrintSide = $this
                    ->articleProductPrintSideFactory
                    ->create();
				
                $articleProductPrintSide
					->setPrintSide($printSide)
					->setArticleProduct($articleProduct);
                
				$articleProduct->addArticleProductPrintSide($articleProductPrintSide);
			});							
		}
        
        return $this;
    }

	/**
     * Presets article product print sides
	 * 
	 * Generates new print side for each not available for selected product print side types
	 * Existing printable variants will be copied to corresponding product print sides
     *
     * @param ArticleProductInterface $articleProduct ArticleProduct
     * @return $this
     */
	public function preSetArticleProductPrintSides(ArticleProductInterface $articleProduct)
	{
		$this->articleProduct = $articleProduct;
		
		$printSideTypes = $this
			->printSideTypeRepository
			->findAll();
		
		$productPrintSides = $this
			->articleProduct
			->getProduct()
			->getPrintSides();
		
		foreach ($printSideTypes as $printSideType) {
			
			$printSideTypeIsAvailable = $productPrintSides
				->exists(function($id, $productPrintSide) use ($printSideType){				
					return $productPrintSide->getType() == $printSideType;
				});             
	
			if (!$printSideTypeIsAvailable) {                 
                $this->handleNotAvailablePrintSide($printSideType);  
            }			
		}
		
		$this->movePrintableVariantsToCorrespondingPrintSides();        
        
        return $this;
	} 
	
    /**
     * Handles not available print sides
     * 
     * @param PrintSideTypeInterface $printSideType
     * @return $this
     */
    private function handleNotAvailablePrintSide(PrintSideTypeInterface $printSideType)
    {
        $printSideTypeExistsInArticle = $this
            ->articleProduct
            ->getArticleProductPrintSides()
            ->exists(function($id, $articleProductPrintSide) use ($printSideType){				
                return $articleProductPrintSide->getPrintSide()->getType() == $printSideType;
            });
            
        if ($printSideTypeExistsInArticle) {
            $this->disableNotAvailablePrintSide($printSideType);
        } else {
            $this->generateMissingPrintSide($printSideType);
        }
        
        return $this;
    }
    
	/**
	 * Generates missing print sides from all existing print side types in the system
	 * 
	 * @param PrintSideTypeInterface $printSideType
	 */
	private function generateMissingPrintSide(PrintSideTypeInterface $printSideType)
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
			->setArticleProduct($this->articleProduct)
            ->disable();

		$this
			->articleProduct
			->addArticleProductPrintSide($articleProductPrintSide);
	}
    
    /**
     * Disables not available print side
     * 
     * @param PrintSideTypeInterface $printSideType
     * @return $this
     */
    private function disableNotAvailablePrintSide(PrintSideTypeInterface $printSideType)
    {
        $this
            ->articleProduct
            ->getArticleProductPrintSides()
            ->map(
                function($articleProductPrintSide) use ($printSideType) {	
                    
                    if ($articleProductPrintSide->getPrintSide()->getType() == $printSideType) {
                        $articleProductPrintSide->disable();
                    }
                }
            );	
            
        return $this;
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
