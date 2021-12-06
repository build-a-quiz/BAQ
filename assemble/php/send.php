<?php

/*
 * send.php
 * In this file we generate the quiz and write it to the database.
 * It takes quiz- and user-data out of the post-request
 *      header:
 *          - userid
 *          - players
 *          - quizname
 *
 *      content:
 *          - quiz-json
 */

session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}

if(!isset($_SERVER['HTTP_QUIZNAME'])) {
    header("location: ../build.php");
    exit;
}

$userId = $_SESSION['id'];
/* POST-REQUEST */
// get user-data from http-request
$players = $_SERVER['HTTP_PLAYERS'];
$quizname = $_SERVER['HTTP_QUIZNAME'];

// get quiz-data from browser
$input = fopen("php://input", 'r');
$json = fgets($input);
fclose($input);

// convert quiz-data to valid json
$obj = json_decode($json, true);
$quizJSON=json_encode($obj);

/* DATABASE */
//// create connection
//$mysqli = new mysqli("localhost", "baq", "baq123", "baq");

require_once "../config/config_db.php";

// check connection
if ($mysqli->connect_error)
    die("Connection failed: " . $mysqli->connect_error);

// convert players to array
$players= explode(',',$players);
$quizzers = array();

// get players id from database
foreach ($players as $player){
    $query = "select user_id from users where username = '$player'";
    $result = $mysqli->query($query);
    $result = $result->fetch_assoc();

    // add player to quizzer
    $quizzers[] = $result['user_id'];
}

// create quiz in database
$newQuiz = "INSERT  INTO quiz(quiz_name, creator, quiz_json)
                    VALUES('$quizname', '$userId','$quizJSON')";
$mysqli->query($newQuiz);

// get quiz-id of the created quiz
$query = "select quiz_id from quiz where quiz_name = '$quizname'";
$result = $mysqli->query($query);
$result = $result->fetch_assoc();
$quiz_id = $result['quiz_id'];

// generate an entry in score for each quizzer
foreach ($quizzers as $quizzer){

    $newQuizzer = "INSERT  INTO score(user_id, quiz_id, points, counter)
                    VALUES($quizzer, $quiz_id, 0, 0)";
    $mysqli->query($newQuizzer);
}

$mysqli->query("INSERT INTO score(user_id, quiz_id, points, counter)
                        VALUES($userId, $quiz_id, 0, 0)");

// close connection
$mysqli->close();


/* DEBUG */
// debug: print all headers
//foreach (getallheaders() as $name => $value) {
//    echo "$name: $value\n";
//}