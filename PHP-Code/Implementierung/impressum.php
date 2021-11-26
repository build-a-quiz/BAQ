<?php
require_once "../config/config.php";
echo '
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Impressum</title>
</head>
<body>
'.PHP_EOL;
Helper::printHeader();
echo '<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-9">
    <h1>
        Impressum
        <small class="text-muted">Team Build a quiz</small>
    </h1>
    <table class="table table-hover">
        <thead>
        <tr>

            <th scope="col">Name</th>
            <th scope="col">Aufgabengebiet</th>
            <th scope="col">E-Mail</th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>Theresa Alt</td>
            <td>Github-Admin, Datenschutzbeauftragte, Bereitstellung generischer PHP-Klassen sowie tpl-Dateien für das Design</td>
            <td>
                <a href="mailto:Theresa.Alt@hof-university.de">
                    Theresa.Alt@hof-university.de
                </a>
            </td>
        </tr>
        <tr>

            <td>Peter Leonov</td>
            <td>Erstellung der Profilseite mit der Möglichkeit Avatare anzulegen, abfragen der erstellten Quizze anhand der Gruppen</td>
            <td>
                <a href="mailto:Peter.Leonov@hof-university.de">
                    Peter.Leonov@hof-university.de
                </a>
            </td>
        </tr>
        <tr>
            <td>Daniel Rohrwild</td>
            <td>Datenbankverantwortlicher, Erstellung der Quizze, Auswertung dieser und Generierung der Rangliste</td>
            <td>
                <a href="mailto:Daniel.Rohrwild@hof-university.de">
                    Daniel.Rohrwild@hof-university.de
                </a>
            </td>
        </tr>
        <tr>
            <td>Philipp Stöhr</td>
            <td>Scrum Master, Erstellung der Login sowie Registrierungsseite mit voller Funktionalität</td>
            <td>
                <a href="mailto:Philipp.Stoehr@hof-university.de">
                    Philipp.Stoehr@hof-university.de
                </a>
            </td>
        </tr>
        <tr>
            <td>Florian Vogl</td>
            <td>Festlegen der Architektur und Erstellung der Quizbauseite sowie deren Hinterlegung in der Datenbank</td>
            <td>
                <a href="mailto:Florian.Vogl@hof-university.de">
                    Florian.Vogl.2@hof-university.de
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>
<br><br><br><br><br><br><br>'.PHP_EOL;
Helper::printFooter();
echo '

</body>
</html>'.PHP_EOL;
