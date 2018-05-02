<?php
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;
use Src\Nasa\Nasa;
use Src\JsonHandler;
use ICanBoogie\Storage\RedisStorage;

$redis = new Redis();
$redis->connect("127.0.0.1");
$prefix = "mars-photos::";

$cache = new RedisStorage($redis, $prefix);

$curl = new Curl();
$jsonHandler = new JsonHandler();

$date = new DateTimeImmutable('2018-01-01');

$nasa = new Nasa($curl, $date,'mars-photos', 'rovers/curiosity/photos');

$data = $jsonHandler->encode($nasa->getData(), true);
echo $data;
$cache->store($date->format('Y-m-d'), $data, true);

//retrive spec day
$cache->retrieve($date->format('Y-m-d'));
