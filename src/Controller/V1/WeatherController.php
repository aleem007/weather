<?php

namespace App\Controller\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\Weather;

/**
 * @Route("weather")
 */
class WeatherController extends AbstractController
{
    /**
     * @Route("/{city}", name="api-v1-weather-by-city")
     */
    public function index(Weather $weather, $city)
    {
        $data = $weather->getWeatherData($city);
        if(!$data) {
            throw new BadRequestHttpException("Bad Request");
        }
        if(!$response = $weather->processWeatherData($data)) {
            throw new \Exception("Something went wrong",Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json($response,Response::HTTP_OK,[
            "Content-Type"=>"application/json",
        ]);
    }
}
