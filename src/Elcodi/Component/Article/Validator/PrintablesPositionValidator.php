<?php

namespace Elcodi\Component\Article\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
use Elcodi\Component\Article\Adapter\PrintablePositionAdapter;
use Elcodi\Bundle\ProductBundle\Entity\Interfaces\PrintSideAreaInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;


class PrintablesPositionValidator extends ConstraintValidator
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
     * @var boolean
     * 
     * Printable variant suits to one of possible print areas of a print side
     */
    private $suitablePrintPositionExists;
    
    public function __construct(PrintablePositionAdapter $printablePositionAdapter) 
    {
        $this->printablePositionAdapter = $printablePositionAdapter;
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
        
        $printSideAreas = $articleProductPrintSide
            ->getPrintSide()
            ->getAreas();
        
        foreach ($articleProductPrintSide->getPrintableVariants() as $printableVariant) {            
            
            $this->suitablePrintPositionExists = false;
            
            $this
                ->checkPositionForPrintSideAreas(
                    $printSideAreas, 
                    $printableVariant
                );
            
            if ($this->suitablePrintPositionExists === false) {
                $this->handleInvalidPrintablePosition($printableVariant, $articleProductPrintSide);
            }
        }
    }
    
    /**
     * Checks if position fits to printable area
     * 
     * @param Collection $printSideAreas
     * @param PrintableVariantInterface $printableVariant
     * @return $this
     */
    private function checkPositionForPrintSideAreas(
        Collection $printSideAreas, 
        PrintableVariantInterface $printableVariant
    ) {  
        foreach ($printSideAreas as $printSideArea) { 
            
            $isValidPositionX = $this->isValidPosition(
                $printableVariant->getPosX(), 
                $printSideArea->getPosX(), 
                $printSideArea->getPosX() + $printSideArea->getWidth()
            );
            
            $isValidPositionY = $this->isValidPosition(
                $printableVariant->getPosY(), 
                $printSideArea->getPosY(), 
                $printSideArea->getPosY() + $printSideArea->getHeight()
            );
            
            if ($isValidPositionX && $isValidPositionY) {                
                $this->suitablePrintPositionExists = true;                
                break;
            }
        }
        
        return $this;
    }
    
    /**
     * Validates printable variant position
     * 
     * @param int $position
     * @param int $printSideAreaPositionMin
     * @param int $printSideAreaPositionMax
     * 
     * @return boolean
     */
    private function isValidPosition(
        int $position, 
        int $printSideAreaPositionMin, 
        int $printSideAreaPositionMax
    ) {
        // @TODO: we have to check if length and heigth of a printable fits to print area, but we don't have this data yet
        return (($printSideAreaPositionMin <= $position) && ($printSideAreaPositionMax >= $position));
    }
    
    /**
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param ArticleProductPrintSideInterface $articleProductPrintSide
     */
    private function handleInvalidPrintablePosition(
        PrintableVariantInterface $printableVariant, 
        ArticleProductPrintSideInterface $articleProductPrintSide
    ) {
        $this
            ->printablePositionAdapter
            ->adaptPrintablePosition($printableVariant, $articleProductPrintSide);

        $this
            ->context
            ->buildViolation($this->constraint->messageWrongPosition)
            ->setParameter('{{ printableType }}', $printableVariant->getType())
            ->setParameter('{{ printableName }}', $this->obtainPrintableTitle($printableVariant))
            ->addViolation();
    }
    
    /**
     * Obtains a title of a printable
     * 
     * @param PrintableVariantInterface $printableVariant
     * @return type
     */
    private function obtainPrintableTitle(PrintableVariantInterface $printableVariant)
    {
        return ($printableVariant->getType() == 'DesignVariant') 
            ? $printableVariant->getDesign()->getName() 
            : $printableVariant->getText()->getContent();
    }
}