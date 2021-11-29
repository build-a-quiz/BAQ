<!doctype HTML>
<html>
<head>

    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href ="../Design/header.css" rel="stylesheet">

    <style>
        table, th{
            border-width: 1px;
            border-style: solid;
            border-color: black;
            padding: 10px;
        }

        h3 {
            margin-top: 25px;
            margin-bottom: 10px;
            text-align: center;
        }

        td{
            text-align: center;
            font-size: 24px;
        }

        th{
            text-align: center;
            font-size: 26px;
        }
    </style>

    <?php
    session_start();
    $user_id = $_SESSION('user_id');

    /*Testing Daniel: */  require_once "C:/xampp/htdocs/BAQ/PHP-Code/config/config.php";
    Helper::printHeader();

    //DB-Abfrage um Ergebnisse von diesem Quiz zu holen
    //Quiz-ID wird über $_GET übergeben
    $quiz_id = $_POST['quiz_id'];

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
			
			<div class='container'>
			<div class='row align-items-center'>
			<div class='col-9'>
			
			<h3>Rangliste: \"".$res['quiz_name']."\" (Quiz-ID: ".$quiz_id.")</h3>
			<table class='table'>
			<th>Profilbild</th> <th>Username</th> <th>Punkte</th>
			";

        //$select = "select * from score where quiz_id=$quiz_id";
        $select = "select u.username, u.user_id, r.points, r.counter from users u inner join score r on u.user_id = r.user_id order by r.points desc";
        $result = $mysqli->query($select);

        $versuche = "select counter from score where quiz_id=$quiz_id";
        $versuche = $mysqli->query($versuche);


        while ($row = $result->fetch_assoc())
        {
            //Anzeige in Rangliste nur, wenn das Quiz mind. 1x gespielt wurde
            if($row['counter'] > 0 && $row['counter'] != "")
            {
                echo "<tr>";

                if(file_exists('C:/xampp/htdocs/BAQ/PHP-Code/upload/'.$row["user_id"].'.jpg'))
                {
                    echo "<td><img height='50px' src='/BAQ/PHP-Code/upload/".$row['user_id'].".jpg'></td>";
                }
                else if(file_exists('C:/xampp/htdocs/BAQ/PHP-Code/upload/'.$row["user_id"].'.png'))
                {
                    echo "<td><img height='50px' src='C:/xampp/htdocs/BAQ/PHP-Code/upload/".$row['user_id'].".png'></td>";
                }
                else
                {
                    echo "<td><img height='50px' src='/BAQ/PHP-Code/upload/BAQ.PNG'></td>";
                }
                //echo "<td><img height='50px' src='/BAQ/PHP-Code/upload/".$row['user_id'].".jpg'</td>";
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
    </div>
    </div>
    </div>
    <?php Helper::printFooter(); ?>
    </body>
</html>