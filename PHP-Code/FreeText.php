<?php
class FreeText extends Question {
    function __construct(){
        $type ="FreeText";
        $this->setType($type);
    }
    public function setQuestion($question, $answers){
        $answers = null;
        echo "<div>
                <form>
                <h3>Tragen Sie die korrekte Antwort in das Eingabefeld ein</h3>
                <p>{$question}</p>
                <div>
                    <label for='FreeTextAnswer'></label>
                    <br>
                    <textarea id='FreeTextAnswer' name='FreeTextSolution' cols='1' rows='1' placeholder='Antwort hier eingeben'></textarea>
                </div>
        </form>
</div>" . PHP_EOL;
readfile('submitButton');
    }
}
