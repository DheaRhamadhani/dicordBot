<?php
use Discord\Discord;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
require_once('./vendor/autoload.php');
require_once('./key.php');
$key = getKey();
$discord = new Discord(['token'=>$key]);
$discord->on('ready', function(Discord $discord){
    echo 'bot is ready';
    $discord->on('message', function($message, $discord){
       $content = $message ->content;
       if(strpos($content, '!') === false) return;

       if($content === '!joke'){ 
        //get a joke from the api
        $client = new \GuzzleHttp\Client();
        $response = $client ->request('GET', 'http://127.0.0.1:8000/products' );
        $joke = json_decode($response -> getBody());
        $joke = $joke-> value;
        $message->reply($joke);
       }
    });
});

$discord->run();