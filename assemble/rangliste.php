<!doctype HTML>
<html>
<head>

    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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

    if(!isset($_GET['quiz_id']) && !isset($_POST['quiz_id']))
        header("location: profile.php");

    $user_id = $_SESSION['id'];

    require_once 'config/config.php';
    require_once 'config/config_db.php';
    Helper::printHeader();

    if(isset($_POST['quiz_id']))
        $quiz_id = $_POST['quiz_id'];

    if(isset($_GET['quiz_id']))
        $quiz_id = $_GET['quiz_id'];

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
        $select = "select u.username, u.user_id, r.points, r.counter from users u inner join score r on u.user_id = r.user_id where quiz_id = $quiz_id order by r.points desc";
        $result = $mysqli->query($select);

        $versuche = "select counter from score where quiz_id=$quiz_id";
        $versuche = $mysqli->query($versuche);


        while ($row = $result->fetch_assoc())
        {
            //Anzeige in Rangliste nur, wenn das Quiz mind. 1x gespielt wurde
            if($row['counter'] > 0 && $row['counter'] != "")
            {
                echo "<tr>";

                if(file_exists('upload/'.$row["user_id"].'.jpg'))
                {
                    echo "<td><img height='50px' src='upload/".$row['user_id'].".jpg'></td>";
                }
                else if(file_exists('upload/'.$row["user_id"].'.png'))
                {
                    echo "<td><img height='50px' src='upload/".$row['user_id'].".png'></td>";
                }
                else
                {
                    echo "<td><img height='50px' src='upload/BAQ.png'></td>";
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


    echo '</table>
    </div>
    </div>
    </div>';
    Helper::printFooter();
    echo '</body>
</html>';
    ?>
