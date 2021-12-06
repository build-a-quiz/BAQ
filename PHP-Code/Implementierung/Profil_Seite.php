<?php
/* // 1. Konfig-Datei für die Nutzung der jeweiligen Klassen laden
require_once '../config/config.php';
Helper::printHeader();
*/

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

    session_start(); //die Variable wird von der Landing Page übergeben
    $user=$_SESSION["user_id"];

    // SQL-Abfrage-String zusammenauen - muss noch angepasst werden
    $abfrage1 = " SELECT * FROM quiz WHERE creator=$user";
    $abfrage2 = " SELECT q.quiz_id, q.quiz_name, u.user_id
                    FROM quiz AS q, users AS u
                    WHERE (u.user_id = q.creator);
                    ";
// AND u.user_id = $user);
    // SQL-Abfrage ausführen und anzeigen
    $result_Tabelle1 = mysqli_query($mysqli, $abfrage1);
    $result_Tabelle2 = mysqli_query($mysqli, $abfrage2);
}
?>
<!-- eine persönliche HTML-Page: tabellarische Abfrage + Bild ändern-->
<!doctype html>
<html lang="de" dir="ltr">

<!-- 2. Im head-Tag des Dokuments Bootstrap einbinden: -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->

<head>
    <meta charset="utf-8">
    <meta name="author" content="BAQ">
    <title>BAQ-Prototyp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--link rel="stylesheet" href="style_Tabellen.css">-->
</head>

<body>

<!-- 3. den Header mit Hilfe der Helper-Klasse einbinden. -->
<!-- Helper::printHeader(); -->

<?php
include "tpl/header.tpl";
?>
<div class="container">
    <div class="row align-items-center">
        <div class="col-9">
<main>
    <h1 class="display-1">Herzlich willkommen, <?php echo $user?> !</h1>
</main>
<?php

if (file_exists("upload/$user.jpg")) { $link_ProfilBild="upload/".$user.".jpg"; }
else {$link_ProfilBild="upload/BAQ.png";}
//echo "Profil_Seite.php: Pfad zum Profilbild: $link_ProfilBild";
?>
<h2 class="display-5">Mein Profilbild:</h2>
</main>
<section name="Bild">
    <img src="<?php echo "$link_ProfilBild"; ?>" class="profilbild" width="150" height="100">

    <!-- 4. Bootstrap Klassen für Zentrierung nutzen: -->

    <!--<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-9"> -->

    <div class="vertical-center">
        <h4>Ein eigenes Profilbild auswählen und hochladen
            (nur .png, .jpg, .jpeg, .gif zulässig) </h4>
        <form
                action=<?php echo "upload.php?user=$user"?> method="post" enctype="multipart/form-data">
            <input class="btn" type="file" name="datei"><br>
            <input class="btn btn-success" type="submit" value="Hochladen">
        </form>
    </div>
<!--
    </div>
    </div>
    </div>
-->
</section>

</br>
<section name="Tabelle1">
    <h2>Meine erstellten Quize:</h2>
    <table class="table">
        <thead>
        <tr>
            <th class="header">Quiz ID</th>
            <th class="header">Quiz Name</th>
            <th class="header">Das gewählte Quiz spielen</th>
            <th class="header">Neue Spalte</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //$link ='<a href="play.php/?user='.$user.'">Jetzt spielen!</a>';
        while($dsatz = mysqli_fetch_assoc($result_Tabelle1)){
            //echo "<tr>";
            echo "<tr>";
            echo "<td>".$dsatz["quiz_id"] ."</td>";
            echo "<td>".$dsatz['quiz_name']."</td>";
            $link ='<a href="play.php/?user='.$dsatz["quiz_id"].'">Jetzt spielen!</a>';
            echo "<td>".$link."</td>";
            $link ='<a href="rangliste.php/?user='.$dsatz["quiz_id"].'">Zur Rangliste!</a>';
            echo "<td>".$link."</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</section>
</br>

<section name="Tabelle2">
    <h2>Meine Quize:</h2>
    <table class="table">
        <thead>
        <tr>
            <th class="header">Quiz ID</th>
            <th class="header">Quiz Name</th>
            <th class="header">Ersteller</th>
            <th class="header">Das gewählte Quiz spielen</th>
            <th class="header">Neue Spalte</th>
        </tr>
        </thead>
        <tbody>
        <?php

        while($dsatz = mysqli_fetch_assoc($result_Tabelle2)){
            echo "<tr>";
            echo "<td>".$dsatz["quiz_id"] ."</td>";
            echo "<td>".$dsatz['quiz_name']."</td>";
            echo "<td>".$dsatz['user_id']."</td>";
            $link ='<a href="play.php/?user='.$dsatz["quiz_id"].'">Jetzt spielen!</a>';
            echo "<td>".$link."</td>";
            $link ='<a href="rangliste.php/?user='.$dsatz["quiz_id"].'">Zur Rangliste!</a>';
            echo "<td>".$link."</td>";
            echo "</tr>";
        }

        //DB-Verbindung schließen
        $mysqli->close();
        ?>
        </tbody>

    </table>
</section>
        </div>
    </div>
</div>
<!--
<footer>

    <nav>
        <h2>Bild A Quiz © 2021</h2>
        <a href="kontakt.html">Kontakt</a> |
        <a href="datenschutz.html">Datenschutzerklärung</a> |
        <a href="https://www.hof-university.de">Hochschule_Hof</a>
    </nav>

</footer>
-->
<!-- 5. Footer eingebinden:-->
<!--Helper::printFooter();-->

<?php
include "tpl/footer.tpl"
?>
</body>

</html>
