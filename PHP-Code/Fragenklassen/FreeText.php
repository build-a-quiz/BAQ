<?php
class FreeText extends Question {
    function __construct(){
        $type ="FreeText";
        $this->setType($type);
    }
    public function buildQuestion($question, $answers){
        $this->getHeader($this->getType());
        echo " <form>
                    <h4>{$question}</h4>
                <div>
                    <input class='form-control' type='text' placeholder='Bitte Antwort hier eingeben...'>
                </div>
                    </form>
                </div>" . PHP_EOL;
    }
}