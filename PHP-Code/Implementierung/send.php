<?php
$input = fopen("php://input", 'r');
$foo = fgets($input);

$file = fopen("foo.php", 'a+');
fwrite($file, "\n".$foo);
fclose($file);
fclose($input);