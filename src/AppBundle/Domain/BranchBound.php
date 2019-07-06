<?php


namespace AppBundle\Domain;

use AppBundle\Domain\Entity\Location;
use AppBundle\Domain\Entity\Node;
use AppBundle\Domain\Util\PriorityQueue;
use Exception;
use RuntimeException;

final class BranchBound
{

    private $n = 0;
    private $locations = [];
    private $costMatrix = [];


    public function __construct($costMatrix = array())
    {
        if ($costMatrix) {
            $this->costMatrix = $costMatrix;
            $this->n = count($this->costMatrix);
        }
    }


    public static function createTreeInstance($locations = null): BranchBound
    {

        $tree = new BranchBound();


        $tree->locations = array();
        $tree->costMatrix = array();


        if ($locations) {
            if ($tree->load($locations) == false) {
                throw new RuntimeException('BranchBound::createTree could not load locations');
            }
        }

        return $tree;
    }

    public function load($locations)
    {
        if (empty($locations)) {
            return false;
        }

        foreach ($locations as $location) {
            if (empty($location)) {
                return false;
            }

            if ($this->addLocation($location) == false) {
                return false;
            }
        }

        return $this->loadMatrix();
    }

    private function addLocation($location)
    {
        try {
            $location = Location::createLocation($location);
        } catch (Exception $e) {
            return false;
        }

        $this->locations[] = $location;

        return true;
    }

    public function loadMatrix()
    {
        if (empty($this->locations)) {
            return false;
        }

        $this->costMatrix = array();
        $n_locations = count($this->locations);
        for ($i = 0; $i < $n_locations; $i++) {
            //echo $i+1 . ". " . $this->locations[$i]->id . "\n";
            for ($j = 0; $j < $n_locations; $j++) {
                $distance = INF;
                if ($i != $j) {
                    $loc1 = $this->locations[$i];
                    $loc2 = $this->locations[$j];
                    $distance = $loc1->distance($loc2);
                }
                $this->costMatrix[$i][$j] = $distance;
            }
        }

        $this->n = count($this->costMatrix);

        return true;
    }

    public function MinimumPathRoute(): array
    {
        $citiesPath = [];

        if (empty($this->costMatrix)) {
            if (!$this->loadMatrix()) {
                return $citiesPath;
            }
        }

        $costMatrix = $this->costMatrix;

        $priorityQueue = new PriorityQueue();


        $rootNode = new Node($costMatrix, null, 0, -1, 0);

        $rootNode->cost = $this->calculateCost($rootNode->reducedMatrix);
        $priorityQueue->insert($rootNode, $rootNode->cost);

        // Finds a live node with least cost,
        // add its children to list of live nodes and
        // finally deletes it from the list.
        while ($priorityQueue->valid()) {
            // Find a live node with least estimated cost
            $min = $priorityQueue->extract();

            // Clear the max estimated nodes
            $priorityQueue = new PriorityQueue();

            // i stores current city number
            $i = $min->vertex;

            // if all cities are visited
            if ($min->level == $this->n - 1) {
                // return to starting city
                $min->path[] = array($i, 0);
                // print list of cities visited;
                $citiesPath = $this->generateCitiesPath($min->path);

                // return optimal cost & etc.
                return $citiesPath;
            }


            for ($j = 0; $j < $this->n; $j++) {
                if ($min->reducedMatrix[$i][$j] !== INF) {
                    // create a child node and calculate its cost
                    $child = new Node($min->reducedMatrix, $min->path, $min->level + 1, $i, $j);
                    $child->cost = $min->cost + $min->reducedMatrix[$i][$j] + $this->calculateCost($child->reducedMatrix);
                    $priorityQueue->insert($child, $child->cost);
                }
            }

            $min = null;
        }
        return $citiesPath;
    }

    private function calculateCost(&$reducedMatrix)
    {
        $cost = 0;

        $row = array();
        $this->rowReduction($reducedMatrix, $row);

        $col = array();
        $this->columnReduction($reducedMatrix, $col);


        for ($i = 0; $i < $this->n; $i++) {
            $cost += ($row[$i] !== INF) ? $row[$i] : 0;
            $cost += ($col[$i] !== INF) ? $col[$i] : 0;
        }

        return $cost;
    }

    private function rowReduction(&$reducedMatrix, &$row)
    {

        $row = array_fill(0, $this->n, INF);

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                if ($reducedMatrix[$i][$j] < $row[$i]) {
                    $row[$i] = $reducedMatrix[$i][$j];
                }
            }
        }

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                if ($reducedMatrix[$i][$j] !== INF && $row[$i] !== INF) {
                    $reducedMatrix[$i][$j] -= $row[$i];
                }
            }
        }
    }

    private function columnReduction(&$reducedMatrix, &$col)
    {

        $col = array_fill(0, $this->n, INF);

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                if ($reducedMatrix[$i][$j] < $col[$j]) {
                    $col[$j] = $reducedMatrix[$i][$j];
                }
            }
        }

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                if ($reducedMatrix[$i][$j] !== INF && $col[$j] !== INF) {
                    $reducedMatrix[$i][$j] -= $col[$j];
                }
            }
        }
    }

    private function generateCitiesPath($list)
    {
        $citiesPath = [];
        for ($i = 0; $i < count($list); $i++) {
            $start = $list[$i][0];
            $citiesPath[] = $this->locations[$start]->id();
        }
        return $citiesPath;
    }


}