<?php
namespace Src\Nasa;

use Curl\Curl;
use DateTimeImmutable;
use Src\Nasa\NasaInterface;

/**
 * Class Nasa
 * @package Src\Nasa
 */
class Nasa implements NasaInterface {

    /**
     *
     */
    const API_URL = 'https://api.nasa.gov/';
    /**
     *
     */
    const API_VERSION = 'v1';

    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var DateTimeImmutable
     */
    private $earth_date;
    /**
     * @var string
     */
    private $api_key;
    /**
     * @var string
     */
    private $apiPreFix;
    /**
     * @var string
     */
    private $camera;
    /**
     * @var string
     */
    private $endPoint;

    /**
     * Nasa constructor.
     * @param Curl $curl
     * @param DateTimeImmutable $earth_date
     * @param string $apiPreFix
     * @param string $endPoint
     * @param string $api_key
     * @param string $camera
     */
    public function __construct(Curl $curl, DateTimeImmutable $earth_date, string $apiPreFix, string $endPoint, string $api_key = 'DEMO_KEY', string $camera = 'NAVCAM'){
        $this->curl = $curl;
        $this->earth_date = $earth_date;
        $this->api_key = $api_key;
        $this->camera = $camera;
        $this->apiPreFix = $apiPreFix;
        $this->endPoint = $endPoint;

    }

    /**
     * @return \Exception|mixed
     */
    public function getData(){
        try{
            return $this->curl->get($this->buildApiUrl());
        } catch (\Exception $exception){
            return $exception;
        }
    }

    /**
     * @return string
     */
    private function buildApiUrl(){
        return self::API_URL.
            $this->apiPreFix.
            '/api/'.
            self::API_VERSION.
            '/'.
            $this->endPoint.
            '?earth_date='.$this->earth_date->format('Y-m-d').
            '&api_key='.$this->api_key.
            '&camera='.$this->camera;
    }
}
