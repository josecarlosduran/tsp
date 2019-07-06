<?php


namespace AppBundle\Domain\Entity;

final class Node
{

    public $path = array();
    public $reducedMatrix = array();
    public $cost;
    public $vertex;
    public $level;

    /**
     * Constructor
     *
     * @param array $parentMatrix The parentMatrix of the costMatrix.
     * @param array $path An array of integers for the path.
     * @param integer $level The level of the node.
     * @param integer $sourceCity , $destinationCity
     *
     */
    public function __construct($parentMatrix, $path, $level, $sourceCity, $destinationCity)
    {
        $this->path = $path;

         if ($level != 0)
        {
            $this->path[] = array($sourceCity, $destinationCity);
        }


        $this->reducedMatrix = $parentMatrix;

        for ($k = 0; $level != 0 && $k < count($parentMatrix); $k++) {

            $this->reducedMatrix[$sourceCity][$k] = INF;
            $this->reducedMatrix[$k][$destinationCity] = INF;
        }


        $this->reducedMatrix[$destinationCity][0] = INF;

        $this->level = $level;
        $this->vertex = $destinationCity;
    }


    public function path()
    {
        return $this->path;
    }




}