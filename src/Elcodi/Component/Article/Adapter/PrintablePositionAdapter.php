<?php

namespace Elcodi\Component\Article\Adapter;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Article\Entity\Interfaces\ArticleProductPrintSideInterface;
use Elcodi\Bundle\PrintableBundle\Entity\Interfaces\PrintableVariantInterface;


/**
 * Class PrintablePositionAdapter
 */
class PrintablePositionAdapter
{
    
    private $printSideAreas;
    
    /**
     * Adapt printable postition to a print side area
     * 
     * @param PrintableVariantInterface $printableVariant
     * @param ArticleProductPrintSideInterface $articleProductPrintSide
     */
    public function adaptPrintablePosition(
        PrintableVariantInterface $printableVariant, 
        ArticleProductPrintSideInterface $articleProductPrintSide
    ) {
        $this->printSideAreas = $articleProductPrintSide
            ->getPrintSide()
            ->getAreas();
        
        $posX = $printableVariant->getPosX();
        $posY = $printableVariant->getPosY();
        
        $closestPrintAreasPosX = $this->findPrintAreasClosestX($posX);
    
        if($closestPrintAreasPosX->count() > 1) {
            $closestPrintArea = $this->findPrintAreaClosestY($posY, $closestPrintAreasPosX);            
        } else {
            $closestPrintArea = $closestPrintAreasPosX->first();
        }
        
        $printableVariant->setPosX($closestPrintArea->getPosX());
        $printableVariant->setPosY($closestPrintArea->getPosY());  
    }
    
    /**
     * Finds print areas with closest X value.
     * There could be several print areas with the same X value, but different Y value
     * 
     * @param int $posX
     * 
     * @return Collection
     */
    private function findPrintAreasClosestX($posX)
    {        
        $closestX = $this->findClosestXValue($posX);
        
        $printSideAreasClosestX = $this
            ->printSideAreas->filter( function($printSideArea) use ($closestX) {                
                return $printSideArea->getPosX() === $closestX;
            });
        
        return $printSideAreasClosestX;
    }
    
    /**
     * Finds closest X value of available print areas
     * 
     * @param int $posX
     * 
     * @return int
     */
    private function findClosestXValue($posX)
    {
        $closestX = null;
        
        $this
            ->printSideAreas
            ->map(function($printSideArea) use ($posX, &$closestX){
            
                $printSideAreaPosX = $printSideArea->getPosX();

                if ($closestX === null || abs($posX - $closestX) > abs($printSideAreaPosX - $posX)) {
                    $closestX = $printSideAreaPosX;               
                }
            });
        
        return $closestX;
    }
    
    /**
     * 
     * @param int $posY
     * @param Collection $closestPrintAreasPosX
     * 
     * @return PrintSideAreaInterface
     */
    private function findPrintAreaClosestY(
        $posY,
        Collection $closestPrintAreasPosX
    ) {
        $printSideAreaClosestY = null;
        $closestY = null;
            
        foreach ($closestPrintAreasPosX as $printSideArea) {
            $printSideAreaPosY = $printSideArea->getPosY();

            if ($closestY === null || abs($posY - $closestY) > abs($printSideAreaPosY - $posY)) {
                $closestY = $printSideAreaPosY; 
                $printSideAreaClosestY = $printSideArea;
            }
        }
     
        return $printSideAreaClosestY;
    }
}

