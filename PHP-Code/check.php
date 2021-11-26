<!doctype HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href ="../Design/header.css" rel="stylesheet">

    <style>
        .right{ border: green 2px solid;
            padding: 5px;
            margin: 2px;
            width: 30%;
            background-color: #F0FFF0;
        }
        .false{ border: red 2px solid;
            padding: 5px;
            margin: 2px;
            width: 30%;
            background-color: #FFA07A;
        }
        .result{
            border: black 2px solid;
            background-color: #D3d3d3;
            width: 30%;
        }

    </style

</head>
<body>

<?php
/*Testing Daniel: */  require_once "C:/xampp/htdocs/BAQ/PHP-Code/config/config.php";
Helper::printHeader();

//Quiz_ID aus GET_Request holen, die beim Klick auf "Quiz-Spielen" die Quiz_ID übermittelt
//$quiz_id = $_GET(['quiz_id']);
$quiz_id = 1;

$user_id = 1; //User_ID aus Session-Variable holen

//DB-Abfrage mit obiger Quiz_ID, um die Daten im JSON-String-Format zu holen:
$mysqli = new mysqli("localhost", "root", "", "baq");

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
$json_daten = json_decode($daten);

//Lösungen aus DB-Json holen:
$counter_dropdown = 1;
$counter_freetext = 1;
$counter_frage_mc = 1;
$counter_gesamtpunktzahl = 0;

//Alle Fragen durchgehen:
$punkte = 0;
$fragen_counter = 0;

foreach($json_daten as $key => $value)
{
    $fragen_counter++;
    $loesung = $json_daten[$key]->solution;

    //Wenn Frage vom Type "dropdown"
    if($json_daten[$key]->type == "dropdown")
    {
        if($loesung == $_POST['DropDown'.$counter_dropdown])
        {
            echo "<div class='right'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Richtig! <br><br>";
            $punkte+=($json_daten[$key]->points);
            echo "</div>";
        }
        else
        {
            echo "<div class='right'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Falsch! <br><br>";
            echo "</div>";
        }

        $counter_dropdown++;
        $counter_gesamtpunktzahl += ($json_daten[$key]->points);
    }
    //Wenn Frage vom Type "freetext"
    else if($json_daten[$key]->type == "freetext")
    {
        if($loesung == $_POST['Auswahl_Freetext'.$counter_freetext])
        {
            echo "<div class='right'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Richtig! <br><br>";
            $punkte+=($json_daten[$key]->points);
            echo "</div>";
        }
        else
        {
            echo "<div class='false'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Falsch! <br><br>";
            echo "</div>";
        }

        $counter_freetext++;
        $counter_gesamtpunktzahl += ($json_daten[$key]->points);
    }

    else if($json_daten[$key]->type == "multiplechoice")
    {
        $antworten = $json_daten[$key]->answers;
        $length = count($antworten);
        $loesungen_length = count($json_daten[$key]->solution); //Ermittlung Anzahl Lösungen
        $count_richtige_antworten = 0;
        $uebermittelte_antworten = 0;

        for($i = 0; $i<$length; $i++)
        {

            if(isset($_POST['Auswahl_MC'.$counter_frage_mc.$i]))
            {
                $uebermittelte_antworten++;

                for($j = 0; $j < $loesungen_length; $j++)
                {
                    if($loesung[$j] == $_POST['Auswahl_MC'.$counter_frage_mc.$i])
                    {
                        $count_richtige_antworten++;
                        break;
                    }
                    else
                    {
                        continue;
                    }
                }
            }
            else
            {
                continue;
            }
        }

        if ($count_richtige_antworten == $loesungen_length && $uebermittelte_antworten == $loesungen_length)
        {
            echo "<div class='right'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Richtig! <br><br>";
            $punkte+=($json_daten[$key]->points);
            echo "</div>";
        }
        else
        {
            echo "<div class='false'>";
            echo "Frage: ".$fragen_counter.": ".$json_daten[$key]->question."<br>";
            echo "Falsch! <br><br>";
            echo "</div>";
        }
        $counter_frage_mc++;
        $counter_gesamtpunktzahl += ($json_daten[$key]->points);
    }

}
echo "<br>";
echo "<div class='result'>";
echo "<h4>Ihr Ergebnis</h4>";

if($punkte == 1)
{
    echo "Sie haben: ".$punkte . " Punkt von insgesamt: ".$counter_gesamtpunktzahl." Punkten erreicht!";
}
else
{
    echo "Sie haben: ".$punkte . " Punkte von insgesamt: ".$counter_gesamtpunktzahl." Punkten erreicht!";
}
echo "</div>";

//Ergebnis in Datenbank eintragen:
//DB-Abfrage mit obiger Quiz_ID, um die Daten im JSON-String-Format zu holen:
$mysqli = new mysqli("localhost", "root", "", "baq");

// DB-Verbindung prüfen
if ($mysqli === false)
{
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
else
{
    $insert = "update score set points = $punkte";
    $mysqli->query($insert);

    $update = "update score set counter = (counter +1) where user_id='$user_id' AND quiz_id='$quiz_id'";
    $mysqli->query($update);
}
// DB-Verbindung schließen
$mysqli->close();

//Weiter zur Rangliste
?>


<br>
<br>
<br>

<!-- Quiz_ID an rangliste.php übergeben -->
<form action="rangliste.php" method="post">
    <?php echo "<input type='hidden' name='quiz_id' value='".$quiz_id."'>"; ?>

    <div class='SubmitButtonBox, text-center'>
        <button type="submit" class="btn btn-info btn-lg">Zur Rangliste</button>
    </div>
    <br>
</form>

<?php

//echo "<a href='rangliste.php?quiz_id=".$quiz_id."'>Zur Rangliste </a>";
Helper::printFooter();
?>

</body>
</html>

