<?php

namespace Tests\AppBundle\Domain\Entity;

use AppBundle\Domain\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class LocationTest extends TestCase
{
    public function testCreateLocation()
    {

        $mock = \Mockery::mock("Location");
        $mock->shouldReceive('createLocation')->once();

        $location = Location::createLocation(array('id' => 'newquay', 'latitude' => 50.413608, 'longitude' => -5.083364));

        $this->assertEquals('newquay', $location->id());
        $this->assertEquals(50.413608, $location->latitude());
        $this->assertEquals(-5.083364, $location->longitude());
    }


    public function testDistance()
    {

        $location = Location::createLocation(array('id' => 'newquay', 'latitude' => 50.413608, 'longitude' => -5.083364));
        $location2 = Location::createLocation(array('id' => 'newquay', 'latitude' => 53.480712, 'longitude' => -2.234377));

        $distance = $location->distance($location2);

        $this->assertEquals(392.8976435935522, $distance);
    }
}
