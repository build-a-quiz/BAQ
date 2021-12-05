<?php

// get user-data from http-request
$userId = $_SERVER['HTTP_CREATOR'];
$players = $_SERVER['HTTP_PLAYERS'];

//echo $players;
$players= explode(',',$players);

foreach ($players as $player){
    echo "Spieler: " . $player . PHP_EOL;
}

// get quiz-data from browser
$input = fopen("php://input", 'r');
$json = fgets($input);
fclose($input);

// convert quiz-data to valid json
$obj = json_decode($json, true);
$quizJSON=json_encode($obj);
echo $quizJSON;

// write json to database


// debug: print all headers
//foreach (getallheaders() as $name => $value) {
//    echo "$name: $value\n";
//}