<?php

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

//Alle Fragen durchgehen:
$punkte = 0;
foreach($json_daten as $key => $value)
{
	$loesung = $json_daten[$key]->solution;
	
	//Wenn Frage vom Type "dropdown"
	if($json_daten[$key]->type == "dropdown")
	{
		if($loesung == $_POST['DropDown'.$counter_dropdown])
		{
			echo "Die Drop-Down Lösung ist: <br>";
			echo "Richtig! <br><br>";
			$punkte+=($json_daten[$key]->points);
		}
		else
		{
			echo "Die Drop-Down Lösung ist: <br>";
			echo "Falsch! <br><br>";
		}
		
		$counter_dropdown++;
	}
	//Wenn Frage vom Type "freetext"
	else if($json_daten[$key]->type == "freetext")
	{
		if($loesung == $_POST['Auswahl_Freetext'.$counter_freetext])
		{
			echo "Die Auswahl_Freetext Lösung ist: <br>";
			echo "Richtig! <br><br>";
			$punkte+=($json_daten[$key]->points);
		}
		else
		{
			echo "Die Auswahl_Freetext Lösung ist: <br>";
			echo "Falsch! <br><br>";
		}

		$counter_freetext++;
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
				echo "Die Auswahl_MC Lösung ist: <br>";
				echo "Richtig! <br><br>"; 
				$punkte+=($json_daten[$key]->points);
		  }
		else
		{
			echo "Die Auswahl_MC Lösung ist: <br>";
			echo "Falsch! <br><br>";
		}
	  $counter_frage_mc++;
	}
	
}

if($punkte == 1)
{
	echo "Sie haben: ".$punkte . " Punkt erreicht!";
}
else
{
	echo "Sie haben: ".$punkte . " Punkte erreicht!";
}

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
<!doctype HTML>
<html>
 <head>
 </head>
 <body>

   <h3>Vergleichen Sie sich mit Ihren Freunden</h3>
<?php
echo "<a href='rangliste.php?quiz_id=".$quiz_id."'>Zur Rangliste </a>";
?>

 </body>
</html>

