<html>
<head>
    <title>BAQ - Play</title>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<?php
session_start();
/* $user_id = $_SESSION['id']; */
$user_id = $_GET['userid'];


if(!isset($_GET['user']))
    header("location: profile.php");

//Einbinden der Konfig-Datei, die die einzelnen Klassen der Fragen enthält

require_once 'config/config.php';
require_once 'config/config_db.php';

Helper::printHeader();

?>

<div class="container">
    <div class="row align-items-center">
        <div class="col-9">
            <br>
            <h2 class="display-2">Fragen</h2>
            <br>
            <?php

            //Quiz_ID aus GET_Request holen, die beim Klick auf "Quiz-Spielen" die Quiz_ID übermittelt
            $quiz_id = $_GET['user'];

            //DB-Abfrage mit obiger Quiz_ID, um die Daten im JSON-String-Format zu holen:
//            $mysqli = new mysqli("localhost", "baq", "baq123", "baq");

            // DB-Verbindung prüfen
            if ($mysqli === false)
            {
                die("ERROR: Could not connect. " . $mysqli->connect_error);
            }
            else
            {

                $select = "select quiz_json from quiz where quiz_id=$quiz_id";
                $result = $mysqli->query($select);
                $result = $result->fetch_assoc();
                $daten = $result['quiz_json']; //in $daten liegt jetzt der String aus der DB
            }

            // DB-Verbindung schließen
            $mysqli->close();

            //String in JSON-Fromat umwandeln
            //print_r($daten);
            $json_daten = json_decode($daten);

            //zu Testzwecken die Daten ausgeben
            // print_r($json_daten);

            //Fragen mit Inhalt aus DB($json_daten) und den vorgefertigten Frage-KLassen zusammenbauen:


            ?>
            <form action="<?php echo "check.php?quiz_id=$quiz_id"?>" method="post">

<?php
				echo "<input type='hidden' id='userid' name='userid' value='$user_id'>";
?>

                <?php
                $fragen_counter = 0;
                //Iteriert über alle Fragen, die erstellt wurden:
                foreach($json_daten as $key => $value) //Liefert die json-Objekte = Anzahl erstellter Fragen
                {
                    $fragen_counter++;
                    echo "<h3>Frage: ".$fragen_counter."</h3>";

                    //Fall 1: Wenn Frage "dropdown"
                    if($json_daten[$key]->type == "dropdown")
                    {
                        $dropDownQuestion = new DropDown();
                        $dropDownQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->answers);
                        echo "<br>";
                    }
                    //Fall 2: Wenn Frage "multiplechoice" (Einfachauswahl)
                    else if($json_daten[$key]->type == "multiplechoice")
                    {
                        $multipleChoiceQuestion = new MultipleChoice();
                        $multipleChoiceQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->answers);
                        echo "<br>";
                    }
                    //Fall 3: Wenn Frage "multiplechoicema" (Mehrfachauswahl)
                    else if($json_daten[$key]->type == "multiplechoicema")
                    {
                        $multipleChoicemaQuestion = new MultipleChoiceMA();
                        $multipleChoicemaQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->answers);
                        echo "<br>";
                    }
                    //Fall 4: Wenn Frage "freetext
                    else if($json_daten[$key]->type == "freetext")
                    {
                        $freeTextQuestion = new FreeText();
                        $freeTextQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->solution);
                        echo "<br>";
                    }
                }
                ?>

                <div class='SubmitButtonBox, text-center'>
                    <button type="submit" class="btn btn-info btn-lg">Jetzt Antworten prüfen</button>
                </div>

                <br>

                <!--<button type="submit">Jetzt Antworten prüfen</button> -->
            </form>

        </div>
    </div>
</div>

<?php Helper::printFooter(); ?>

</body>


</html>
