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

}
