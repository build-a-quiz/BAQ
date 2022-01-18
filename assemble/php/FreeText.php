<?php
class FreeText extends Question {

    static $freeTextCounter = 0;

    function __construct(){
        $type ="FreeText";
        $this->setType($type);
        FreeText::$freeTextCounter++;
    }
    public function buildQuestion($question, $answers){
        // $this->getHeader($this->getType());
        echo " 
                    <h4 class='display-8'>{$question}</h4>
                <div class='col-xs-3'>
                    <input class='form-control' id='x3' type='text' name='Auswahl_Freetext".FreeText::$freeTextCounter++."' placeholder='Bitte Antwort hier eingeben...'>
                </div>
                " . PHP_EOL;
    }
}