<?php

declare(strict_types=1);

namespace td1334\cliform;

class CliFormQuestion
{
    public string $question;
    public ?string $response;
    public string $default="";

    public bool $casesensitive = false;

    public array $requirements;

    public function __construct($frage, $default=false, $requirements=false, $sensitive=false) {
        $this->question = $frage;
        $this->response = "";
        $this->requirements = [];

        if(false!==$default)      $this->setDefault($default);
        if(false!==$requirements) $this->setRequirements($requirements);
        $this->setCaseSensitive($sensitive);
        return $this;
    }

    public function setDefault($default):CliFormQuestion {
        $this->default = $default;
        //if(empty($k)) $key = $val;
        //$this->requirements[ mb_strtolower($default) ] = $default;
        return $this;
    }

    public function setRequirements(string $req): CliFormQuestion {
        foreach(explode(",", $req) as $val) {
                $val = trim($val);
            $this->requirements[ mb_strtolower($val) ] = $val;
        }
        return $this;
    }

    public function setCaseSensitive(?bool $sensitive): CliFormQuestion {
        $this->casesensitive = $sensitive;
        return $this;
    }

    public function setSensitive(): CliFormQuestion {
        $this->casesensitive = true;
        return $this;
    }

    public function setInsensitive(): CliFormQuestion {
        $this->casesensitive = false;
        return $this;
    }

    public function getAnswers(): string {
        $a = "";
        if(count($this->requirements)>0) {
            if($this->casesensitive) {
                $a = implode(", ", $this->requirements);
            } else {
                $a = implode(", ", array_keys($this->requirements));

            }
            $a = " [" . $a . "]";
        }
        return $a;
    }


    public function run():string {
        do {
            echo $this->question;
            echo $this->getAnswers() . " : ";

            $fin = fopen("php://stdin", "r");
            $eingabe = trim(fgets($fin), "\r\n\t");

            if (empty($eingabe)) {
                if (!empty($this->default)) {
                    $eingabe = $this->default;
                }
            }

            $repeat = true;
            if ($this->casesensitive) {
                $key = mb_strtolower($eingabe);
                if(count($this->requirements)>0) {
                    if (isset($this->requirements[$key]) && $this->requirements[$key] == $eingabe ) {
                        $repeat = false;
                        $antwort = $this->requirements[$key];
                    } else {
                        $repeat = true;
                    }
                } else {
                    $repeat = false;
                    $antwort = $eingabe;
                }
            }
            else {
                $key = mb_strtolower($eingabe);
                if(count($this->requirements)>0) {
                    if (isset($this->requirements[$key])) {
                        $repeat = false;
                        $antwort = $this->requirements[$key];
                    } else {
                        $repeat = true;
                    }
                } else {
                    $repeat = false;
                    $antwort = $eingabe;
                }

            }
            if($repeat) {
                echo "\nError: Please type one of the following answers".$this->getAnswers()."\n";
            }
        } while($repeat);

        $this->response = $antwort;
        return $antwort;
    }

}