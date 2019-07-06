<?php

namespace Tests\AppBundle\Domain;


use AppBundle\Domain\BranchBound;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class BranchBoundTest extends TestCase
{
    public function testMinimumPathRoute()
    {


        $locations =    [
            ['id' => 'newquay', 'latitude' => 50.413608, 'longitude' => -5.083364],
            ['id' => 'manchester', 'latitude' => 53.480712, 'longitude' => -2.234377],
            ['id' => 'london', 'latitude' => 51.500152, 'longitude' => -0.126236],
            ['id' => 'birmingham', 'latitude' => 52.483003, 'longitude' => -1.893561]
        ];

        $expectedPath = ["newquay","london","birmingham","manchester"];


        $tsp = BranchBound::createTreeInstance($locations);
        $path = $tsp->minimumPathRoute();

        $this->assertEquals($expectedPath, $path);


    }




}
