<?php
abstract class Question {
    private string $question;
    private array $answers;
    private string $solution;
    private string $type;
    private int $points;

    //abstract function that builds questions as html according to their parameters
    abstract function buildQuestion($question, $answers);

    //generic Getters & Setters
    public function setQuestion($question){
        $this->question = $question;
    }
    public function setAnswers($answers){
        $this->answers = $answers;
    }
    public function setSolution($solution){
        $this->solution = $solution;
    }
    public function setPoints($points){
        $this->points= $points;
    }
    public function setType($type){
        $this->type = $type;
    }
    public function getQuestion(): string{
        return $this->question;
    }
    public function getSolution(): string{
        return $this->solution;
    }
    public function getAnswers(): array{
        return $this->answers;
    }
    public function getPoints(): int{
        return $this->points;
    }
    public function getType(): string{
        return $this->type;
    }
/*
    //Printing the header for a question into HTML dependent upon it's type
    public function getHeader($type){
        if($type == "MultipleChoice" || $type == "DropDown"){
            echo "<div>
                <br>
                <h4 class='display-3'>
                    <small class='text-muted'>
                        Wählen Sie die korrekte Antwort aus
                    </small>
                </h4>
                <br>". PHP_EOL;
        } elseif ($type == "FreeText"){
            echo "<div>
                <br>
                <h4 class='display-3'>
                    <small class='text-muted'>
                        Tragen Sie die korrekte Antwort in das Eingabefeld ein
                    </small>
                </h4>
                <br>".PHP_EOL;
        } else {
            echo "<h4 class='display-3'> Kein gültiger Klassentyp mitgegeben</h4>".PHP_EOL;
        }
    }
	*/
	
    //Short function for implementing a Confirm-Button
    public function implementButton(){
        readfile('submitButton.tpl');
    }
}
