<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Forecast;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $barcelona = $this->addLocation($manager, 'Barcelona', 'ES', 41.38879, 2.15899);

        $monday = $this->addForecast($manager, $barcelona, '2024-01-01', 23, 25, 1009, 49, 7.7, 90, 0, 'sun');
        $tuesday = $this->addForecast($manager, $barcelona, '2024-01-02', 20, 17, 999, 70, 3.2, 45, 70, 'cloud');
        $wednesday = $this->addForecast($manager, $barcelona, '2024-01-03', 21, 22, 1025, 40, 0.7, 0, 25, 'cloud-sun');


        $berlin = $this->addLocation($manager, 'Berlin', 'DE', 52.520008, 13.404954);

        $monday = $this->addForecast($manager, $berlin, '2024-01-01', 11, 9, 989, 92, 1, 180, 75, 'cloud-rain');
        $tuesday = $this->addForecast($manager, $berlin, '2024-01-02', 10, 10, 1000, 50, 3.2, 90, 70, 'cloud');
        $wednesday = $this->addForecast($manager, $berlin, '2024-01-03', 15, 13, 1010, 45, 0.7, 0, 25, 'cloud-sun');
   

        $paris = $this->addLocation($manager, 'Paris', 'FR', 48.864716, 2.349014);

        $monday = $this->addForecast($manager, $paris, '2024-01-01', 25, 24, 1007, 49, 6.5, 80, 0, 'sun');
        $tuesday = $this->addForecast($manager, $paris, '2024-01-02', 21, 19, 995, 68, 3.8, 47, 70, 'cloud');
        $wednesday = $this->addForecast($manager, $paris, '2024-01-03', 23, 21, 1015, 54, 1.9, 0, 25, 'cloud-sun');

        $manager->flush();
    }

    private function addLocation(
        ObjectManager $manager, 
        string $name, 
        string $code, 
        float $latitude, 
        float $longitude
        ): Location
    {
        $location = new Location();
        $location
            ->setName($name)
            ->setCountryCode($code)
            ->setLatitude($latitude)
            ->setLongitude($longitude);

            $manager->persist($location);

        return $location;
    }

    private function addForecast(
        ObjectManager $manager,
        Location $location, 
        string $dateString, 
        int $celsius, 
        int $flCelsius, 
        int $pressure, 
        int $humidity, 
        float $windSpeed, 
        int $windDeg, 
        int $cloudiness, 
        string $icon
        ): Forecast
    {
        $forecast = new Forecast();
        $forecast
            ->setDate(new DateTime($dateString))
            ->setLocation($location)
            ->setTemperatureCelsius($celsius)
            ->setFlTemperatureCelsius($flCelsius)
            ->setPressure($pressure)
            ->setHumidity($humidity)
            ->setWindSpeed($windSpeed)
            ->setWindDeg($windDeg)
            ->setCloudiness($cloudiness)
            ->setIcon($icon);

        $manager->persist($forecast);

        return $forecast;
    }
}
