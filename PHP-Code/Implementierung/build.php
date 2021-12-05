<?php

// write quiz to databse
//if (isset($_POST['submit'])) {
//
//}

// just for testing set username and userid
$user = "rassil0n";
$userid = "1337";

require_once '../config/config.php';
$freeTextQuestion = new FreeText();
$multipleChoiceQuestion = new MultipleChoice();
$dropDownQuestion = new DropDown();

// ugly way to pass php-variable for javascript
echo "<input type='hidden' id='username' value='$user'>";
echo "<input type='hidden' id='userid' value='$userid'>";

echo '<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>BAQ - Let\'s Build</title>
    <link rel="shortcut icon" href="../../resources/BAQ.PNG" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.8/bootstrap-4/bootstrap-4.min.css">
          
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.2.1/sweetalert2.min.js" integrity="sha512-qsog2Un5vHgtBLsgIIcZcfcRNxUXAswH2TxciIVDcB/reXRm1hFyH5Eb1ubQDUK149uK2HzuC0HFcqtSY5F1gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>' . PHP_EOL;
Helper::printHeader();
echo "
<div class='container'>
    <div class='row align-items-center'>
        <div class='col-9'>
            <br>
                <h1 class='display-1'>Let's build!
                    <h4>
                        <small class='text-muted'>
                            $user - erstelle dein eigenes Quiz und messe dich mit anderen
                        </small>
                    </h4>
                </h1>
            <br>
          " . PHP_EOL;

//$multipleChoiceQuestion->buildQuestion("Welcher Wissenschaftler sollte keine lebende Katze in die Finger bekommen?", ["Albert Einstein", "Robert Oppenheimer", "MarieCurie", "Max Planck", "Erwin Schrödinger"]);
//echo "<br><br><hr><br>" . PHP_EOL;
//$dropDownQuestion->buildQuestion("Was ist die höchstwertige technische Entwicklung auf Basis des Tunneleffekts ", ["Hochfrequenz-Halbleiter", "Cooper-Paare", "Gleichmäßig verteilter Käse auf Nachos"]);
//echo "<hr>" . PHP_EOL;
//$freeTextQuestion->buildQuestion("Wie wird ein Qubit auf der Bloch-Kugel dargestellt?", ["Vektor"]);
//$multipleChoiceQuestion->setQuestion("Hello World");
//echo $multipleChoiceQuestion->getQuestion();

?>

    <script src="funcs.js"></script>

    <script>
        // function to send the question to the server

        let allQ = [];
        let allU = [];
        function send() {

            // get information about quiz and players
            let creator = document.getElementById('userid').value
            let players = allU.toString()
            let quizname = document.getElementById('quizname').value

            // generate new request
            let req = new XMLHttpRequest();
            req.open("POST", 'send.php');
            req.setRequestHeader("creator", creator);
            req.setRequestHeader("players", players);
            req.setRequestHeader('quizname', quizname);

            // send request to server
            req.send(JSON.stringify(allQ));
            console.log(allQ)
            // location.reload();

            if(quizname) {
                swal.fire({
                    icon: 'success',
                    title: "Quiz " + quizname + " wurde erfolgreich erstellt und in der Datenbank gespeichert",
                    confirmButtonText: 'Alles klar!',
                }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('quizname').value=''
                            location.reload()
                        }
                    })
            }
            else {
                swal.fire({
                    icon: 'warning',
                    title: "Es wurde kein Quizname vergeben!"
                })
            }

            // $.ajax({
                //     type: 'POST',
                //     url: 'send.php',
                //     data: fnord,
                //     success: function () {
                //         location.reload();
                //     }
                // });
        }

        // function to generate new Free-Text Question

    </script>

    <hr>
    <div class="input-group input-group-default mb-2">
    <span class="input-group-text" id="inputGroup-sizing-default">Quizname</span>
    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="quizname">
    </div>
    <div class="btn-group">
    <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Frage hinzufügen
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <button class="dropdown-item" type="button" onclick="addFreeText()">Freitext</button>
            <button class="dropdown-item" type="button" onclick="addDropDown()">Dropdown</button>
            <button class="dropdown-item" type="button" onclick="addMultipleChoice()">Multiple Choice</button>
        </div>
    </div>
        <button class="btn"></button>
<button class="btn btn-warning" onclick="addUser()">Quizzer hinzufügen</button>
</div>

    <hr>

    <br><br>
<h6 class="display-6">Quizzer</h6> <h6 class="subtitle text-muted">Wer soll an dem Quiz teilnehmen können</h6>
<table class="table table-responsive table-borderless table-sm" id="players">
</table>

    <br><br>

<h6 class="display-6">Preview des Quiz</h6> <h6 class="subtitle text-muted">(Achtung kein voller Funktionsumfang)</h6>
    <!--   Preview the quiz-->
    <div id="preview">
    </div>


<!--    <form action="send.php" method="post">-->

        <br> <br>
<!--        <hr>-->
        <br>
        <div class="SubmitButtonBox, text-center">
            <button onclick="send()" class="btn btn-info btn-lg">Quiz erstellen</button>
        </div>
        <br>
<!--        <hr>-->
        <br> <br>
<!--    </form>-->

<button onclick="send()">Test send</button>

<?php
//Helper::printButton();
echo '
               </div>
            </div>
          </div>' . PHP_EOL;
Helper::printFooter();
echo '
    </body>
</html>
' . PHP_EOL;

?>