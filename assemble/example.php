<?php
require_once 'config/config.php';
$freeTextQuestion = new FreeText();
$multipleChoiceQuestion = new MultipleChoice();
$multipleChoiceQuestionMA = new MultipleChoiceMA();
$dropDownQuestion = new DropDown();

/* session_start(); */

/* // Check if the user is logged in, if not then redirect him to login-page */
/* if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){ */
/*     header("location: index.php"); */
/*     exit; */
/* } */

echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Quiztypes - Prototyp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</head>
<body>'. PHP_EOL;
Helper::printHeader();
echo '
<div class="container">
    <div class="row align-items-center">
        <div class="col-9">
            <br>
                <h1 class="display-2">Beispielseite für ein Quiz
                    <h4>
                        <small class="text-muted">
                            Welche Fragentypen können mit Build-A-Quiz erstellt werden
                        </small>
                    </h4>
                </h1>
            <br>
          '.PHP_EOL;
        $multipleChoiceQuestionMA->buildQuestion("Wie lassen sich Qubits realisieren?", ["Photonen", "Elektronen", "Ionen", "Spannung"]);
        echo "<br><br><hr><br>".PHP_EOL;
        $multipleChoiceQuestion->buildQuestion("Welcher Wissenschaftler sollte keine lebende Katze in die Finger bekommen?", ["Albert Einstein", "Robert Oppenheimer", "MarieCurie", "Max Planck", "Erwin Schrödinger"]);
        echo "<hr>".PHP_EOL;
        $freeTextQuestion->buildQuestion("Wie wird ein Qubit auf der Bloch-Kugel dargestellt?", ["Vektor"]);

            echo "<br><br><hr><br>".PHP_EOL;
            $dropDownQuestion->buildQuestion("Was ist die höchstwertige technische Entwicklung auf Basis des Tunneleffekts ", ["Hochfrequenz-Halbleiter", "Cooper-Paare", "Gleichmäßig verteilter Käse auf Nachos"]);


            Helper::printButton();
            echo '
               </div>
            </div>
          </div>'.PHP_EOL;
          Helper::printFooter();
            echo '
    </body>
</html>
' .PHP_EOL;
