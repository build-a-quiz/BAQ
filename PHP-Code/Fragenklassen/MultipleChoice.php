<?php
/* //Stand: 29.11.2021
class MultipleChoice extends Question{
    private int $counter = 0;
	static $mc_fragen_counter = 0;

    function __construct(){
        $type ="MultipleChoice";
        $this->setType($type);
		MultipleChoice::$mc_fragen_counter++;
    }
    function buildQuestion($question, $answers){
       // $this->getHeader($this->getType());
        echo "
                    <h4 class='display-8'>{$question}</h4>
                    <div>".PHP_EOL;
                    foreach ($answers as $answer){
                        $count = $this->counter++;
                        echo '
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="Auswahl_MC'.MultipleChoice::$mc_fragen_counter.$count.'" id="option'.$count.'" value="'.$count.'">
                                <label class="form-check-label" for="option'.$count.'">' .$answer. '</label>
                            </div>' .PHP_EOL;
                    }
                    echo "</div>" . PHP_EOL;
    }
}
*/

//Stand: 30.11.201
class MultipleChoice extends Question{
    private int $counter = 0;
    static $mc_fragen_counter = 1;

    function __construct(){
        $type ="MultipleChoice";
        $this->setType($type);
    }
    function buildQuestion($question, $answers){
        // $this->getHeader($this->getType());
        echo "
                    <h4 class='display-8'>{$question}</h4>
                    <div>".PHP_EOL;
        foreach ($answers as $answer){
            $count = $this->counter++;
            echo '
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="inlineRadio1" name="radio'.MultipleChoice::$mc_fragen_counter.'" id="option'.$count.'" value="'.$count.'">
                                <label class="form-check-label" for="inlineRadio1">' .$answer. '</label>
                            </div>' .PHP_EOL;
        }
        echo "</div>" . PHP_EOL;
        MultipleChoice::$mc_fragen_counter++;
    }
}


