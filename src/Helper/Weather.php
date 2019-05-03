<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Weather
{
    private $params;
    private $utility;
    public function __construct(ParameterBagInterface $params, Utility $utility)
    {
        $this->params = $params;
        $this->utility = $utility;
    }

    public function getWeatherData($city) {
        $client = new \GuzzleHttp\Client();
        /* \GuzzleHttp\Psr7\Response $response */
        $response = $client->request("GET", $this->params->get('api_base_url'),
            [
                "query" => ["q" => $city],
                "headers" => [
//                        'Accept' => 'application/json',
                    'x-api-key' => $this->params->get('weather_api_key'),
                ]
            ]
        );
        if ($response->getStatusCode() != Response::HTTP_OK) {
            return false;
        }

        $data = $response->getBody()->getContents();

        return $data;

    }

    public function processWeatherData($data)
    {
        if(!$this->utility->isJson($data)){
            return false;
        }

        $weatherArray = json_decode($data,true);
        $response = array(
            "weather_type"=> $weatherArray["weather"][0]["main"]??"",
            "temperature"=>$weatherArray["main"]["temp"]??"",
            "wind"=>array(
                "speed"=>$weatherArray["wind"]["speed"]??"",
                "direction"=>$weatherArray["wind"]["deg"]?$this->utility->findDirectionByDegree($weatherArray["wind"]["deg"]):"",
            )
        );

        return $response;
    }
}

