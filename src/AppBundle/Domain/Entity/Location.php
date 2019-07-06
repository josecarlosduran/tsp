<?php


namespace AppBundle\Domain\Entity;

use RuntimeException;

final class Location
{

    private $latitude;
    private $longitude;
    private $id;

    public function __construct($latitude, $longitude, $id = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->id = $id;
    }

    public static function createLocation(array $a_location) :Location
    {
        $location = (array) $a_location;
        if (empty($location['latitude']) || empty($location['longitude']))
        {
            throw new RuntimeException('Location:: Latitude and Longitude are mandatory');
        }
        $id = isset($location['id']) ? $location['id'] : null;
        return new Location($location['latitude'], $location['longitude'], $id);

    }

    public function distance(Location $location)
    {

        $lat1 = $this->latitude();
        $lon1 = $this->longitude();
        $lat2 = $location->latitude();
        $lon2 = $location->longitude();

        if ($lat1 == $lat2 && $lon1 == $lon2) return 0;

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);

    }


    public function latitude()
    {
        return $this->latitude;
    }


    public function longitude()
    {
        return $this->longitude;
    }


    public function id()
    {
        return $this->id;
    }



}