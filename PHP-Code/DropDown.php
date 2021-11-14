<?php

class DropDown extends Question{
    private int $counter = 0;
	static $dropdown_fragen_counter = 0;
	
    function __construct(){
        $type ="DropDown";
        $this->setType($type);
		DropDown::$dropdown_fragen_counter++;
    }
	
	
    function buildQuestion($question, $answers){
        //$this->getHeader($this->getType());
        echo "
                    <h4>{$question}</h4>
                    <div>
                        <select class='form-select' name='DropDown".DropDown::$dropdown_fragen_counter."'aria-label='Bitte Anwort auswählen'>
                            <option>Bitte Antwort auswählen...</option>".PHP_EOL;
                    foreach ($answers as $answer){
                        $count = $this->counter++;
                        echo '
                            <option id='.$count.' value='.$count.'>'.$answer.'</option>
                            ' .PHP_EOL;
                    }
                    echo "</select>
                    </div>
                
            </div>" . PHP_EOL;
    }
}
?>

