<?php
class MultipleChoice extends Question{
    private int $counter = 0;
    function __construct(){
        $type ="MultipleChoice";
        $this->setType($type);
    }
    function setQuestion($question, $answers, $solution){
        $this->question= question;
        $this->answers = $answers;
        $this->solution = $solution;
        echo "<div>
                <br>
                <h4 class='display-3'>
                <small class='text-muted'>
                Wählen Sie die korrekte Antwort aus
                </small>
                </h4>
                <br>
                <form>
                <h4 class='display-4'>{$question}</h4>
                <div>".PHP_EOL;
                foreach ($answers as $value){
                    $this->counter++;
                    echo '
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="option.{$counter}" value="option{$counter}">
                          <label class="form-check-label" for="option{$counter}">' .$value. '</label>
                    </div>' .PHP_EOL;
                }
            echo "</div>
        </form>
</div>" . PHP_EOL;
    }
}