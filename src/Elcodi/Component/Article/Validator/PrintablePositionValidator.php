<?php

namespace Elcodi\Component\Article\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
use Elcodi\Component\Article\Adapter\PrintablePositionAdapter;
use Elcodi\Component\Article\Adapter\PrintableSizeAdapter;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;

class PrintablePositionValidator extends ConstraintValidator
{
    /**
     * @var Constraint 
     * 
     * Constraint object
     */
    private $constraint;
    
    /**
     * @var PrintablePositionAdapter
     * 
     * Printable position adapter 
     */
    private $printablePositionAdapter;   
    
    /**
     * @var PrintableSizeAdapter
     * 
     * Printable size adapter 
     */
    private $printableSizeAdapter;   
    
    /**
     * Construct
     * 
     * @param PrintablePositionAdapter $printablePositionAdapter
     * @param PrintableSizeAdapter $printableSizeAdapter
     */
    public function __construct(
        PrintablePositionAdapter $printablePositionAdapter,
        $printableSizeAdapter
    ) {
        $this->printablePositionAdapter = $printablePositionAdapter;
        $this->printableSizeAdapter = $printableSizeAdapter;
    }

    /**
     * Validate 
     * 
     * @param ArticleProductPrintSideInterface $articleProductPrintSide
     * @param Constraint $constraint
     */
    public function validate($articleProductPrintSide, Constraint $constraint) 
    {
        $this->constraint = $constraint;
        
        foreach ($articleProductPrintSide->getPrintableVariants() as $printableVariant) {            
            
            $printSideArea = $this->findSuitablePrintSideArea($articleProductPrintSide, $printableVariant);
          
            if ($printSideArea === false) {
                $this
                    ->printablePositionAdapter
                    ->adaptPrintablePosition($printableVariant, $articleProductPrintSide);
                
                $this->createConstraintViolation($printableVariant, $this->constraint->messageWrongPosition);
                
                continue;
            }
            
            $this->checkPrintableVariantFitsToArea($printableVariant, $printSideArea); 
        }
    } 
    
    /**
     * Find suitable print area
     * 
     * @param ArticleProductPrintSideInterface $articleProductPrintSide
     * @param PrintableVariantInterface $printableVariant
     * 
     * @return PrintSideAreaInterface
     */
    private function findSuitablePrintSideArea(
        ArticleProductPrintSideInterface $articleProductPrintSide, 
        PrintableVariantInterface $printableVariant
    ) {
        return $articleProductPrintSide
            ->getPrintSide()
            ->getAreas()
            ->filter(function($printSideArea) use ($printableVariant){                    
                return $this->isLeftTopCornerInsideArea($printableVariant, $printSideArea);
            })
            ->first();
    }
    
    /**
     * Check if a printable variant fits to an area
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param PrintSideAreaInterface $printSideArea
     * 
     * @return $this
     */
    private function checkPrintableVariantFitsToArea(
        PrintableVariantInterface $printableVariant, 
        PrintSideAreaInterface $printSideArea
    ) {
        $printableFitsToArea = $this->isRightBottomCornerInsideArea($printableVariant, $printSideArea); 
          
        if (!$printableFitsToArea) {

            $printableResized = $this
                ->printableSizeAdapter
                ->setPrintSideArea($printSideArea)
                ->setPrintableVariant($printableVariant)
                ->adaptPrintableSize();

            if ($printableResized) {                                        
                $this->createConstraintViolation($printableVariant, $this->constraint->messagePrintableResized);
            } else {
                $this->createConstraintViolation($printableVariant, $this->constraint->messagePrintableNotResized);
            }
        }
        
        return $this;
    }

    /**
     * Check if the left top corner of a printable is placed inside of an area
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param PrintSideAreaInterface $printSideArea
     * 
     * @return boolean 
     */
    private function isLeftTopCornerInsideArea(
        PrintableVariantInterface $printableVariant, 
        PrintSideAreaInterface    $printSideArea
    ) {
        $isValidPositionX = $this->isPositionValid(
                $printableVariant->getPosX(), 
                $printSideArea->getPosX(), 
                $printSideArea->getPosX() + $printSideArea->getWidth()
            );
        
        $isValidPositionY = $this->isPositionValid(
            $printableVariant->getPosY(), 
            $printSideArea->getPosY(), 
            $printSideArea->getPosY() + $printSideArea->getHeight()
        );
        
        return $isValidPositionX && $isValidPositionY;
    }
    
    /**
     * Check if the right bottom corner of a printable is placed inside of an area
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param PrintSideAreaInterface $printSideArea
     * 
     * @return boolean
     */
    private function isRightBottomCornerInsideArea(
        PrintableVariantInterface $printableVariant, 
        PrintSideAreaInterface    $printSideArea
    ) {
        $isValidPositionX = $this->isPositionValid(
            $printableVariant->getPosX() + $printableVariant->getWidth(), 
            $printSideArea->getPosX(), 
            $printSideArea->getPosX() + $printSideArea->getWidth()
        );        
      
        $isValidPositionY = $this->isPositionValid(
            $printableVariant->getPosY() + $printableVariant->getHeight(), 
            $printSideArea->getPosY(), 
            $printSideArea->getPosY() + $printSideArea->getHeight() 
        ); 

        return $isValidPositionX && $isValidPositionY;
    }    

    /**
     * Validate printable variant position
     * 
     * @param int $position
     * @param int $printSideAreaPositionMin
     * @param int $printSideAreaPositionMax
     * 
     * @return boolean
     */
    private function isPositionValid(
        $position, 
        $printSideAreaPositionMin, 
        $printSideAreaPositionMax 
    ) {        
        return (($printSideAreaPositionMin <= $position) && ($printSideAreaPositionMax >= $position));
    }
    
    /**
     * Handle invalid printable position
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param string $message
     */
    private function createConstraintViolation(
        PrintableVariantInterface $printableVariant, 
        $message
    ) {
        $printableTitle = ($printableVariant->getType() == 'DesignVariant') 
            ? $printableVariant->getDesign()->getName() 
            : $printableVariant->getText()->getContent();
        
        $this
            ->context
            ->buildViolation($message)
            ->setParameter('{{ printableType }}', $printableVariant->getType())
            ->setParameter('{{ printableName }}', $printableTitle)
            ->addViolation();
    }
}