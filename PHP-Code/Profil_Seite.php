<?php
// Zur Datenbank verbinden
$mysqli = new mysqli("localhost", "root", "", "baq");

// DB-Verbindung prüfen
    if ($mysqli === false)
	 {
       die("ERROR: Could not connect. " . $mysqli->connect_error);
  	}
	else //einen tabellarischen Bericht erstellen
	 {
     // die Variable $user soll von der Start-Page ausgenommen werden
     $user = 1; //die Variable wird weiter an die "upload.php" übergeben
 /*
     session_start(); //die Variable wird von der Landing Page übergeben
     $user=$_SESSION["user_id"];
 */
		// SQL-Abfrage-String zusammenauen - muss noch angepasst werden
			$abfrage1 = "SELECT * FROM quiz WHERE creator=$user";
      $abfrage2 = "SELECT * FROM quiz WHERE creator=$user";

		// SQL-Abfrage ausführen und anzeigen
		$result_Tabelle1 = mysqli_query($mysqli, $abfrage1);
    $result_Tabelle2 = mysqli_query($mysqli, $abfrage2);
  }
?>
<!-- eine persönliche HTML-Page: tabellarische Abfrage + Bild ändern-->
<!doctype html>
<html lang="de" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="BAQ">
        <title>BAQ-Prototyp</title>
        <link rel="stylesheet" href="style_Tabellen.css">
    </head>

    <body>
    <main>
        <h1>Herzlich willkommen, <?php echo $user?> !</h1>
    </main>
    <?php

    if (file_exists("upload/$user.jpg")) { $link_ProfilBild="upload/".$user.".jpg"; }
    else {$link_ProfilBild="upload/BAQ.png";}
    echo "Profil_Seite.php: Pfad zum Profilbild: $link_ProfilBild";
    ?>
    <h2>Mein Profilbild:</h2>
  </main>
    <section name="Bild">
        <img src="<?php echo "$link_ProfilBild"; ?>" class="profilbild" width="150" height="100">
            <div class="vertical-center">
              <form
              action=<?php echo "upload.php?user=$user"?> method="post" enctype="multipart/form-data">
              <input type="file" name="datei"><br>
              <input type="submit" value="Hochladen">
              </form>
            </div>
        </div>
    </section>

        </br>
        <section name="Tabelle1">
            <h2>Meine erstellten Quize:</h2>
            <table class="Bericht1">
                <thead>
                <tr>
                    <th class="header">Quiz ID</th>
                    <th class="header">Quiz Name</th>
                </tr>
                </thead>
                <tbody>
                  <?php

                  		while($dsatz = mysqli_fetch_assoc($result_Tabelle1)){
                        echo "<tr>";
                        echo "<td>".$dsatz["quiz_id"] ."</td>";
                  			echo "<td>".$dsatz['quiz_name']."</td>";
                        echo "</tr>";
                  		  }
                  		 // DB-Verbindung schließen
                       //$mysqli->close();
                  ?>
                </tbody>
            </table>
        </section>
        </br>


        <section name="Tabelle2">
            <h2>Meine Quize:</h2>
            <table class="Bericht2">
                <thead>
                <tr>
                    <th class="header">Quiz ID</th>
                    <th class="header">Quiz Name</th>
                    <th class="header">Ersteller</th>
                </tr>
                </thead>
                <tbody>
                  <tbody>
                    <?php

                    		while($dsatz = mysqli_fetch_assoc($result_Tabelle2)){
                          echo "<tr>";
                          echo "<td>".$dsatz["quiz_id"] ."</td>";
                    			echo "<td>".$dsatz['quiz_name']."</td>";
                          echo "<td>".$dsatz['total_points']."</td>";
                          echo "</tr>";
                    		  }

                    		 //DB-Verbindung schließen
                         $mysqli->close();
                    ?>
                  </tbody>

            </table>
        </section>

        <footer>

            <nav>
                <h2>Bild A Quiz © 2021</h2>
                <a href="kontakt.html">Kontakt</a> |
                <a href="datenschutz.html">Datenschutzerklärung</a> |
                <a href="https://www.hof-university.de">Hochschule_Hof</a>
            </nav>

        </footer>

    </body>

</html>
