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
                    <h4>{$question}</h4>
                <div>
                    <input class='form-control' type='text' name='Auswahl_Freetext".FreeText::$freeTextCounter++."' placeholder='Bitte Antwort hier eingeben...'>
                </div>
                 
                </div>" . PHP_EOL;
    }
}