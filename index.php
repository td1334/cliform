<?php

namespace td1334;

use td1334\cliform\CliFormQuestion;

include "vendor/autoload.php";

$frage = (new CliFormQuestion("frage"))
        ->setDefault("yes")
        ->setRequirements("no,maybe")
        ->setCaseSensitive(false)
    ;

$frage = (new CliFormQuestion("frage", "yes", "yes, no, maybe", false));
$frage = (new CliFormQuestion("frage"))->run();
$frage = (new CliFormQuestion("frage", "yes", "yes, no, maybe", false));


$antwort = $frage->run();

//print_r($frage);
print_r($antwort);