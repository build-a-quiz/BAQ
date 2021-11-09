<?php
require_once '../config/config.php';
$freeTextQuestion = new FreeText();
$multipleChoiceQuestion = new MultipleChoice();
$dropDownQuestion = new DropDown();
echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Quiztypes - Prototyp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row align-items-center">
        <div class="col-9">
            <br>
                <h1 class="display-1">Fragen
                    <h4>
                        <small class="text-muted">
                            Welche Fragentypen können mit Build-A-Quiz erstellt werden
                        </small>
                    </h4>
                </h1>
            <br>
          '.PHP_EOL;
            $freeTextQuestion->setQuestion("Wie wird ein Qubit auf der Bloch-Kugel dargestellt?", "Vektor", "Vektor");
            $multipleChoiceQuestion->setQuestion("Welcher Wissenschaftler sollte keine lebende Katze in die Finger bekommen?", ["Albert Einstein", "Robert Oppenheimer", "MarieCurie", "Max Planck", "Erwin Schrödinger"], "Erwin Schrödinger");
            $dropDownQuestion->setQuestion("Was ist die höchstwertige technische Entwicklung auf Basis des Tunneleffekts ", ["Hochfrequenz-Halbleiter", "Cooper-Paare", "Gleichmäßig verteilter Käse auf Nachos"], "Gleichmäßig verteilter Käse auf Nachos");
            echo '
               </div>
            </div>
          </div>
    </body>
</html>
' .PHP_EOL;