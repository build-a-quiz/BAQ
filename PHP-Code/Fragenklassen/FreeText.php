<?php
class FreeText extends Question {
    function __construct(){
        $type ="FreeText";
        $this->setType($type);
    }
    public function setQuestion($question, $answers, $solution){
        $answers = null;
        echo "<div>
                <br>
                <h4 class='display-3'>
                    <small class='text-muted'>
                        Tragen Sie die korrekte Antwort in das Eingabefeld ein
                    </small>
                </h4>
                <br>
                <form>
                    <h4>{$question}</h4>
                <div>
                    <input class='form-control' type='text' placeholder='Bitte Antwort hier eingeben...'>
                </div>
                    </form>
                </div>" . PHP_EOL;
    }
}