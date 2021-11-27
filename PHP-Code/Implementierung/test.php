<?php

require_once '../config/config.php';
$multipleChoiceQuestion = new MultipleChoice();
$multipleChoiceQuestion->buildQuestion("Welcher Wissenschaftler sollte keine lebende Katze in die Finger bekommen?", ["Albert Einstein", "Robert Oppenheimer", "MarieCurie", "Max Planck", "Erwin Schrödinger"]);
