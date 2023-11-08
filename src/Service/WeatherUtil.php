<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    public function __construct(
        private MeasurementRepository $measurementRepository,
        private LocationRepository $locationRepository,
    )
    {}

    /**
     * @return
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    /**
     * @return
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if (!$location) {
            throw new \Exception('Location not found');
        }

        return $this->measurementRepository->findByLocation($location);

    }
}
