<?php

use td1334\cliform;
use td1334\cliform\CliFormQuestion;

include "vendor/autoload.php";

/*
//$frage = (new CliFormQuestion("frage", "yes", "yes, no, maybe", false));
//$antwort = $frage->run();
$antwort = (new CliFormQuestion("frage", "yes", "yes, no, maybe", false))->run();
//print_r($frage);
print_r($antwort);
*/

$form = new cliform\Cliform();
$form->add("vorname", new CliFormQuestion("Vorname", "yes", "yes, no, maybe", false));
$form->add("strasse", new CliFormQuestion("Strasse"));
$form->run();
print_r($form->getValue("strasse"));
print_r($form);