<?php

class DropDown extends Question{
    private int $counter = 0;
    function __construct(){
        $type ="DropDown";
        $this->setType($type);
    }
    function buildQuestion($question, $answers){
        $this->getHeader($this->getType());
        echo "<form>
                    <h4>{$question}</h4>
                    <div>
                        <select class='form-select' aria-label='Bitte Anwort auswählen'>
                            <option selected>Bitte Antwort auswählen...</option>".PHP_EOL;
        foreach ($answers as $answer){
            $count = $this->counter++;
            echo '
                            <option value='.$count.'>'.$answer.'</option>
                            ' .PHP_EOL;
        }
        echo "</select>
                    </div>
                </form>
            </div>" . PHP_EOL;
    }
}