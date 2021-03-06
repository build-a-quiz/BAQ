<?php

class DropDown extends Question{
    private int $counter = 0;
    static $dropdown_fragen_counter = 0;

    function __construct(){
        $type ="DropDown";
        $this->setType($type);
        DropDown::$dropdown_fragen_counter = DropDown::$dropdown_fragen_counter+1;
    }


    function buildQuestion($question, $answers){
        //$this->getHeader($this->getType());
        echo "
                    <h4 class='display-8'>{$question}</h4>
                    <div class='col-xs-3'>
                        <select class='form-select' id='x3' name='DropDown".DropDown::$dropdown_fragen_counter."'aria-label='Bitte Anwort auswählen'>
                            <option>Bitte Antwort auswählen...</option>".PHP_EOL;
        foreach ($answers as $answer){
            $count = $this->counter++;
            echo '
                            <option id='.$count.' value='.$count.'>'.$answer.'</option>
                            ' .PHP_EOL;
        }
        echo "</select>
                    </div>". PHP_EOL;
    }
}
?>

