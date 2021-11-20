<html>
 <head>
  <meta charset="utf-8"/>
 </head>
 <body>

<?php
//Einbinden der Konfig-Datei, die die einzelnen Klassen der Fragen enthält
require_once "./config.php";

//Quiz_ID aus GET_Request holen, die beim Klick auf "Quiz-Spielen" die Quiz_ID übermittelt
//$quiz_id = $_GET(['quiz_id']);
$quiz_id = 1;

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

//zu Testzwecken die Daten ausgeben
//print_r($json_daten); 	
 
//Fragen mit Inhalt aus DB($json_daten) und den vorgefertigten Frage-KLassen zusammenbauen:

?>
  <form action="check.php" method="post">

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
		}
        //Fall 2: Wenn Frage "multiplechoice"
		else if($json_daten[$key]->type == "multiplechoice")
		{
			$multipleChoiceQuestion = new MultipleChoice();
			$multipleChoiceQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->answers);
		}
        //Fall 3: Wenn Frage "freetext
		else if($json_daten[$key]->type == "freetext")
		{
			$freeTextQuestion = new FreeText();
			$freeTextQuestion->buildQuestion($json_daten[$key]->question,$json_daten[$key]->solution);
       }
    }
?>

   <br>
   <button type="submit">Jetzt Antworten prüfen</button>
  </form>

 </body>
</html>