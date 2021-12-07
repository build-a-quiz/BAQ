<?php
/* // 1. Konfig-Datei für die Nutzung der jeweiligen Klassen laden
require_once '../config/config.php';
Helper::printHeader();
*/

// DB-Verbindung prüfen

include "config/config_db.php";

if ($mysqli === false) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
} else //einen tabellarischen Bericht erstellen
{
    // die Variable $user soll von der Start-Page ausgenommen werden

    session_start(); //die Variable wird von der Landing Page übergeben

// Check if the user is logged in, if not then redirect him to login-page
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
        header("location: index.php");
        exit;
    }
    $user = $_SESSION["id"];
    $username = $_SESSION["username"];

	echo "UserID: $user";

    // SQL-Abfrage-String zusammenauen - muss noch angepasst werden
    $abfrage1 = " SELECT * FROM quiz WHERE creator=$user";
    /* $abfrage2 = " SELECT q.quiz_id, q.quiz_name, u.user_id, u.username */
    /*                 FROM users u inner join quiz q inner join score s */
    /*                 on u.user_id = s.user_id; */
    /*                 "; */

	/* $abfrage2 = " SELECT s.user_id, q.username, s.quiz_id FROM (users u inner join score s on s.user_id = $user) inner join quiz q on q.creator != $user where s.user_id = $user;"; */
	$abfrage2 = " SELECT s.user_id, s.quiz_id, q.quiz_name, (select username from users where user_id = q.creator) as username from score s inner join quiz q on s.quiz_id = q.quiz_id where s.user_id = $user;";
// AND u.user_id = $user);
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
    <title>BAQ - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

<?php
include "tpl/header.tpl";
?>
<br>
<div class="container">
    <div class="row align-items-center">
        <div class="col-9">
            <main>
                <h1 class="display-3">Herzlich willkommen, <?php echo $username ?>!</h1>
            </main>
            <?php

            if (file_exists("upload/$user.png")) {
                $link_ProfilBild = "upload/" . $user . ".png";
            } else {
                $link_ProfilBild = "upload/BAQ.png";
            }
            ?>
            <hr>
            <h5 class="display-6">Mein Profilbild:</h5>
            <section>
                <img src="<?php echo "$link_ProfilBild"; ?>" class="profilbild" width="150" alt="Profilbild des Users">

                <div class="vertical-center">
                    <h4>Ein eigenes Profilbild auswählen und hochladen
                    </h4>
                    <h6 class="subtile text-muted">(nur .png, .jpg, .jpeg, .gif zulässig)</h6>
                    <form action="<?php echo "php/upload.php?user=$user" ?>" method="post" enctype="multipart/form-data">
                        <input class="btn" type="file" name="datei">
                        <input class="btn btn-success" type="submit" value="Hochladen">
                    </form>
                </div>
            </section>

            <hr>

            <br>
            <section>
                <h2>Meine erstellten Quizze:</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="header">Quiz ID</th>
                        <th class="header">Quiz Name</th>
                        <th class="header">Das gewählte Quiz spielen</th>
                        <th class="header">Wie schaut es aus?!</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //$link ='<a href="play.php/?user='.$user.'">Jetzt spielen!</a>';
                    while ($dsatz = mysqli_fetch_assoc($result_Tabelle1)) {
                        //echo "<tr>";
                        echo "<tr>";
                        echo "<td>" . $dsatz["quiz_id"] . "</td>";
                        echo "<td>" . $dsatz['quiz_name'] . "</td>";
                        $link = '<a href="play.php?user=' . $dsatz["quiz_id"] . '&userid=' . $user .'">Jetzt spielen!</a>';
                        /* $link = '<a href="play.php?user=' . $dsatz["quiz_id"] . '">Jetzt spielen!</a>'; */
                        echo "<td>" . $link . "</td>";
                        $link = '<a href="rangliste.php?quiz_id=' . $dsatz["quiz_id"] . '">Zur Rangliste!</a>';
                        echo "<td>" . $link . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </section>
            <br>

            <section>
                <h2>Meine spielbaren Quizze:</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="header">Quiz ID</th>
                        <th class="header">Quiz Name</th>
                        <th class="header">Ersteller</th>
                        <th class="header">Das gewählte Quiz spielen</th>
                        <th class="header">Wie schaut es aus?!</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($dsatz = mysqli_fetch_assoc($result_Tabelle2)) {
                        echo "<tr>";
                        echo "<td>" . $dsatz["quiz_id"] . "</td>";
                        echo "<td>" . $dsatz['quiz_name'] . "</td>";
                        echo "<td>" . $dsatz['username'] . "</td>";
                        $link = '<a href="play.php?user=' . $dsatz["quiz_id"] . '&userid=' . $user .'">Jetzt spielen!</a>';
                        echo "<td>" . $link . "</td>";
                        $link = '<a href="rangliste.php?quiz_id=' . $dsatz["quiz_id"] . '">Zur Rangliste!</a>';
                        echo "<td>" . $link . "</td>";
                        echo "</tr>";
                    }

                    ?>
                    </tbody>

                </table>
            </section>
        </div>
    </div>
</div>

<?php
include "tpl/footer.tpl";
$mysqli->close();
?>
</body>

</html>
