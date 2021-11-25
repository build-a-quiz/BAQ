<!doctype HTML>
<html>
 <head>
  <style>
   table, th{
    border-width: 1px;
	border-style: solid;
	border-color: black;
	padding: 10px;
   }
  </style>
  
<?php

//DB-Abfrage um Ergebnisse von diesem Quiz zu holen
//Quiz-ID wird über $_GET übergeben
$quiz_id = $_GET['quiz_id'];

$mysqli = new mysqli("localhost", "root", "", "baq");

// DB-Verbindung prüfen
    if ($mysqli === false) 
	 {
       die("ERROR: Could not connect. " . $mysqli->connect_error);
     } 
	else 
	 {
		 $quiz_name = "select quiz_name from quiz where quiz_id=$quiz_id";
		 $quiz_name = $mysqli->query($quiz_name);
		 $res = $quiz_name->fetch_assoc();
		 
		 echo "  
			</head>
			<body>
			<h3>Rangliste: \"".$res['quiz_name']."\" (Quiz-ID: ".$quiz_id.")</h3>
			<table>
			<th>Profilbild</th> <th>Username</th> <th>Punkte</th>
			";
		 
       //$select = "select * from score where quiz_id=$quiz_id";
        $select = "select u.username, r.points, r.counter from users u inner join score r on u.user_id = r.user_id order by r.points desc";
		$result = $mysqli->query($select);
		
		$versuche = "select counter from score where quiz_id=$quiz_id";
		$versuche = $mysqli->query($versuche);	
		

		while ($row = $result->fetch_assoc())
		{
         //Anzeige in Rangliste nur, wenn das Quiz mind. 1x gespielt wurde
		 if($row['counter'] > 0 && $row['counter'] != "")
		  {
			echo "<tr>";
			echo "<td>User-Images einfügen</td>";
			echo "<td>".$row['username']."</td>";
			echo "<td>".$row['points']."</td>";
			echo "</tr>";
		  }
	     } 
		
	  }
	 
// DB-Verbindung schließen
$mysqli->close();	

?>

  </table>
 </body>
</html>