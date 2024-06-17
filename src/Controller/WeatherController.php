<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{countryCode}/{city}', name: 'app_weather')]
    public function forecast(string $countryCode, string $city): Response
    {
        return $this->render('weather/index.html.twig', [
            'country_code' => $countryCode,
            'city' => $city
        ]);
    }
}
