<?php
abstract class Question {
    private string $question;
    private array $answers;
    private string $solution;
    private string $type;
    private int $points;

    abstract function setQuestion($question, $answers, $solution);

    public function getQuestion(): string{
        return $this->question;
    }
    public function getSolution(): string{
        return $this->solution;
    }
    public function getAnswers(): array{
        return $this->answers;
    }
    public function setPoints($points){
        $this->points= $points;
    }
    public function getPoints(): int{
        return $this->points;
    }
    public function setType($type){
        $this->type = $type;
    }
    public function getType(): string{
        return $this->type;
    }
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
    public function implementButton(){
        readfile('../tpl/submitButton.tpl');
    }
}
